import network #import des fonction liée au wifi
import urequests #import des fonction liée au requetes http
import utime #import des fonction liée au temps
import ujson #import des fonction liée à la convertion en Json
from machine import *
from time import *
from dictag import *

wlan = network.WLAN(network.STA_IF) # met la raspi en mode client wifi
wlan.active(True) # active le mode client wifi

ssid = ''
password = ''
wlan = network.WLAN(network.STA_IF) # connecte la raspi au réseau
wlan.active(True)
wlan.connect(ssid, password)
url = "config.php"





list_led = [PWM(Pin(17, mode=Pin.OUT)), PWM(Pin(18, mode=Pin.OUT)), PWM(Pin(19, mode=Pin.OUT))]



while(True):
    try:
        # print("GET")
        r = urequests.get(url) # lance une requete sur l'url
        tag = r.json()["post_tag"]
        print("Le tag de ce post est" + tag) # traite sa reponse en Json
        for i in range(3):
            list_led[i].duty_u16(dic_tag[tag])
        r.close() # ferme la demande
    except Exception as e:
        print(e)