#!/usr/local/bin/python3

import csv
import uuid
import hashlib
import base64

u_id = 10002 

def hash_password(password):
    h = base64.b64encode(hashlib.sha256(str.encode(password)).digest())
    return h.decode("utf-8")

with open('users.csv', newline='') as csvfile:
    reader = csv.DictReader(csvfile, delimiter=';')
    for row in reader:
        #print(row['login'], row['password'])
        cpass = hash_password(row['password'])
        u_id = (u_id + 1)
        print("INSERT INTO ftp_user (ftpgroup_id, username, firstname, lastname, password, uid, home, shell, last_login, login_count, active) VALUES (%d, '%s', '%s', 'Dyadem', '{SHA256}%s', %d, '/space/FtpSites/dyamde/%s', '/bin/sh', NOW(), 0, true);" % (
            4, row['login'], row['login'], cpass, u_id, row['login'] 
        )) 



# COPY ftp_user (id, ftpgroup_id, username, firstname, lastname, password, uid, home, shell, last_login, login_count, active) FROM stdin;
#1	3	hlepesant	Hugues	Lepesant	{SHA256}Kd5enuIj7V8YdptrC8u5s0QRaieSxfVqARmQpl4QuXs=	10001	/opt/FtpSites/oxalide/hlepesant	/bin/sh	2018-07-16 13:56:33	4	t

