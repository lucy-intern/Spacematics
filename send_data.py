#*******************************************************************************/
# Name:    send_data2.py														#
# Purpose: This code captures an image through the PI Camera and sends it to 	#
#			the VM instance														#
# Input:   NONE																	#
# Output:  Image sent to the VM instance										#
# Authors: Akshit Bagde, B. Bharatwaajan, Sarah									#
# Dated:   5 July, 2019															#
#*******************************************************************************/



import os
from picamera import PiCamera

os.environ["GOOGLE_APPLICATION_CREDENTIALS"]="key.json" # Gives access for the code to use the Google Cloud Project 
camera = PiCamera()

while True:
    camera.start_preview()
    camera.capture('/home/thinkphi/data_rpi.jpg')
    camera.stop_preview()    
    os.system('gcloud compute scp data_rpi.jpg lucy_intern@instanceforvision:') #sends the image
