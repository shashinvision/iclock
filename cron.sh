#!/bin/bash
#Author: Felipe Mancilla
#date: 2022-01-31
#web: http://felipemancilla.herokuapp.com/
# Ejemplo de creación del cronjob aca: 
# SHELL=/bin/sh
# PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin
# */1 * * * * sh /var/www/html/iclock/cron.sh 10.6.17.116


ip=$1;

cronJob(){
    for i in 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31 32 33 34 35 36 37 38 39 40 41 42 43 44 45 46 47 48 49 50 51 52 53 54 55 55 56 57 58 59 60
        do 
            #sleep 1 && curl --silent "http://localhost/iclock/cdata.php?ip=$ip" &> /dev/null
            sleep 1 && curl --silent --output /dev/null "http://localhost/iclock/cdata.php?ip=$ip"
            #sleep 1 && echo "Se ejecuto la vez numero $i en $ip"
        done 
}

cronJob