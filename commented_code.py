#*******************************************************************************/
# Name:    pre_jarvis2.py
# Purpose: This code takes input image and process it through face_recognition and AutoML, giving output data and storing it in SQL database
# Input:   Image file from raspberry pi
# Output:  Data sent to SQL database and image is uploaded to google cloud bucket
# Authors: Akshit Bagde, B. Bharatwaajan, Sarah
# Dated:   5 July, 2019
#*******************************************************************************/

import numpy as np
import sys
import os

#For connecting to Google cloud platform
from google.cloud import automl_v1beta1
from google.cloud.automl_v1beta1.proto import service_pb2
from google.cloud import storage

#For face recognition
import cv2
import face_recognition as fr

#For placing current timestamp
import time
from datetime import datetime

#For SQL database
import mysql.connector

#Establish enviornment for our unique project in Google cloud platform
os.environ["GOOGLE_APPLICATION_CREDENTIALS"]="key.json"

#Used in face_recognition
known_faces = []
face_names = []
user_number = 0

#Connecting to cloud SQL server
mydb = mysql.connector.connect(
	host='35.226.147.71',
	user='root')
myc =mydb.cursor()
myc.execute("USE lucy")

'''
This function get_prediction, takes input-
  1. content (image file)
  2. project_id (Project Name of Google cloud platform)
  3. model_id (unique id of our AutoMl trained model)
  4. number_of_users (Input from the face recognition code)

This function takes the image input,returns the output confidence scores from model and stores everything into SQL database
'''
def get_prediction(content, project_id, model_id,number_of_users):
  prediction_client = automl_v1beta1.PredictionServiceClient()
  name = 'projects/{}/locations/us-central1/models/{}'.format(project_id, model_id)
  payload = {'image': {'image_bytes': content }}
  params = { "score_threshold":"0.0" }  # Returns the output of activities having confidence score is greater than "0.0"
  request = prediction_client.predict(name, payload, params)
  labels = request.payload
  conf = [0.0, 0.0, 0.0, 0.0] #Array to store confience scores of activities
  i = 0
  while i<len(labels):
  	image_label = labels[i].display_name # print this
  	score_result = labels[i].classification
  	confidence = score_result.score # print this
  	conf[i] = confidence
    print(image_label)
  	print(confidence)
  	i = i+1

  #Insert into SQL database
  sql = "INSERT INTO Jarvis2 (Eating, Idle, Phone, Reading, RID,USERS) VALUES (%s, %s, %s, %s, %s, %s)"
  val = (conf[0], conf[1], conf[2], conf[3], '0',number_of_users)
  myc.execute(sql,val)
  mydb.commit()
  
  # waits till request is returned
  return request 

#Main function running in the loop
while True:
  if __name__ == '__main__':
    file_path = '/home/lucy_intern/data_rpi0_copy.jpg' #File path of the image sent from raspi-0
    project_id = "spacematics"#Project_id Spacematics of Google cloud platform
    model_id = "ICN839481751021398691"#Unique Model Id of trained AutoMl model
    exists = os.path.isfile('data_rpi0.jpg')#Check if the file exists
 
    if exists:
      os.system('mv data_rpi0.jpg data_rpi0_copy.jpg')
      time.sleep(2)
      
      #Face Recognition
      pic = cv2.imread('data_rpi0_copy.jpg')
      pic = cv2.resize(pic,(0,0),fx =2,fy=2 ) #Resize image for face_recognition
      pic = pic[:,:,::-1] # changing the RGB faces captured by Rpi to BGR format for face_recognition to work on
      detected_names = [] # list to store the faces identified in the current frame
      number_of_faces = len(fr.face_locations(pic)) # the function returns the locations of the faces identified in the frame
      print('Number of faces: '+str(number_of_faces))
      face_locations = fr.face_locations(pic)
      face_encodings = fr.face_encodings(pic,face_locations) # returns the face encodings of the faces in the in the face_locations list 
      if number_of_faces>0:  
        for face_encoding in face_encodings:  
   	       matches = fr.compare_faces(known_faces,face_encoding,tolerance = 0.5) # The distance between two faces in the euclidean distance sense is et to be 0.5 for them to be categorised as different
  	       name = None
	         if True in matches:
	           first_match_index = matches.index(True)
	           name = face_names[first_match_index]
             detected_names.append(name) # If any faces match with the already known faces, we add that name to the detected names list of this frame
	         if sum(matches)==0:
	           known_faces.append(face_encoding)
             user_number = user_number +1
	           name = "user"+str(user_number)
	           face_names.append(name)
	           detected_names.append(name) # If a new face has been identified, he is added to the known face encodings and also to the detected names list
          print("Detected faces: "+str(detected_names)) 
    
    #Calling get_prediction function
    with open(file_path, 'rb') as ff:
      content = ff.read() # opening the raspi0_copy.jpg
    get_prediction(content, project_id,  model_id,number_of_faces) # Calling the AutoML function
    
    # Assigning the timestamp as the name to the image that is abeing stored in the Bucket
    date = str(datetime.utcnow())
    date = date[:-7]
    date = date.replace(" ","_") #Filename should not have spaces
    date = date.replace(":","_") #Filename should not have " : "
    name = "{}jpg".format(date) 
    print("0\n") # print Raspi ID - 0
    print(name) #print image name - timestamp.jpg

    #Store image in Bucket
    client = storage.Client()
    bucket = client.bucket('spacematics-vcm')
    blob = bucket.blob('data_rpi0/{}'.format(name))
    blob.upload_from_filename('data_rpi0_copy.jpg')

    # Removing the created data_rpi0_copy.jpg to continue to the loop
    os.system('rm data_rpi0_copy.jpg') 
    print('-----------------------------------------------------')
