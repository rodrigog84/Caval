#!/bin/bash
VAR_RANDOM=$RANDOM
CONSULTADIA=0
DIA=$(date --date=${CONSULTADIA}+' day ago' +\%d)
MES=$(date --date=${CONSULTADIA}+' day ago' +\%m)
ANO=$(date --date=${CONSULTADIA}+' day ago' +\%Y)

mv /home/sistema/SISTEMAS/ELECT/*.CSV /var/www/html/Caval/core/facturacion_electronica/csv/
wget http://192.168.0.10/Caval/core/index.php/procesos/lectura_csv_fe
mv /var/www/html/Caval/core/facturacion_electronica/csv/*.CSV /var/www/html/Caval/core/facturacion_electronica/csv/procesados/FACT_PROC_$ANO$MES$DIA_${VAR_RANDOM}.CSV

