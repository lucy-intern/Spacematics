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

 # Gives access for the code to use the Google Cloud Project
os.environ["GOOGLE_APPLICATION_CREDENTIALS"]="key.json" 

camera = PiCamera()

while True:
    camera.start_preview()
    camera.capture('/home/thinkphi/data_rpi0.jpg')
    camera.stop_preview()   
     
     #sends the image to the virtual machine on the cloud
    os.system('gcloud compute scp data_rpi0.jpg lucy_intern@jarvis-instance:')
