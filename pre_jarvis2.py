import numpy as np
import sys
import os
from google.cloud import automl_v1beta1
from google.cloud.automl_v1beta1.proto import service_pb2
import cv2
import time
from google.cloud import storage
from datetime import datetime
import face_recognition as fr
import mysql.connector


known_faces = []
face_names = []
user_number = 0

os.environ["GOOGLE_APPLICATION_CREDENTIALS"]="key.json"
runtime = 10;

mydb = mysql.connector.connect(
	host='35.226.147.71',
	user='root')
myc =mydb.cursor()
myc.execute("USE lucy")

def get_prediction(content, project_id, model_id,number_of_users):
  prediction_client = automl_v1beta1.PredictionServiceClient()

  name = 'projects/{}/locations/us-central1/models/{}'.format(project_id, model_id)
  payload = {'image': {'image_bytes': content }}
  params = { "score_threshold":"0.0" }
  request = prediction_client.predict(name, payload, params)
  
  labels = request.payload
  conf = [0.0, 0.0, 0.0, 0.0]
  #print(len(labels))
  
  i = 0
  while i<len(labels):
  	image_label = labels[i].display_name # print this
  	score_result = labels[i].classification
  	confidence = score_result.score # print this
  	conf[i] = confidence
        print(image_label)
  	print(confidence)
  	i = i+1
  sql = "INSERT INTO Jarvis2 (Eating, Idle, Phone, Reading, RID,USERS) VALUES (%s, %s, %s, %s, %s, %s)"
  val = (conf[0], conf[1], conf[2], conf[3], '0',number_of_users)
  myc.execute(sql,val)
  mydb.commit()
  
  return request  # waits till request is returned

i = 0
while True:
  if __name__ == '__main__':
    file_path = '/home/lucy_intern/data_rpi0_copy.jpg'
    project_id = "spacematics"
    model_id = "ICN839481751021398691"
    exists = os.path.isfile('data_rpi0.jpg')
 
    if exists:
      os.system('mv data_rpi0.jpg data_rpi0_copy.jpg')
      time.sleep(2)
      pic = cv2.imread('data_rpi0_copy.jpg')
      pic = cv2.resize(pic,(0,0),fx =2,fy=2 )
      pic = pic[:,:,::-1]
      detected_names = []
      number_of_faces = len(fr.face_locations(pic))
      print('Number of faces: '+str(number_of_faces))
      face_locations = fr.face_locations(pic)
      face_encodings = fr.face_encodings(pic,face_locations) 
      if number_of_faces>0:  
        for face_encoding in face_encodings:  
   	  matches = fr.compare_faces(known_faces,face_encoding,tolerance = 0.5)
  	  name = None
	  if True in matches:
	    first_match_index = matches.index(True)
	    name = face_names[first_match_index]
            detected_names.append(name)
	  if sum(matches)==0:
	    known_faces.append(face_encoding)
            user_number = user_number +1
	    name = "user"+str(user_number)
	    face_names.append(name)
	    detected_names.append(name)
      print("Detected faces: "+str(detected_names))
      with open(file_path, 'rb') as ff:
        content = ff.read()
      get_prediction(content, project_id,  model_id,number_of_faces)
      date = str(datetime.utcnow())
      date = date[:-7]
      date = date.replace(" ","_")
      date = date.replace(":","_")
      name = "{}jpg".format(date)
      print("0\n")
      print(name)
      client = storage.Client()
      bucket = client.bucket('spacematics-vcm')
      blob = bucket.blob('data_rpi0/{}'.format(name))
      blob.upload_from_filename('data_rpi0_copy.jpg')
      os.system('rm data_rpi0_copy.jpg')
      print('-----------------------------------------------------')
    i=i+1 
