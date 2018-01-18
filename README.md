# Billing System - PDAM Jayapura
## Keterangan
Aplikasi billing system pdam jayapura berbasis PHP & MySQL
SELECT DATE_FORMAT(DATE(now()-INTERVAL 1 MONTH),'%Y%m');
SELECT nomor,nolama,nama,dkd,periode,standlalu,standkini,pakai,uangair,adm,meter,IF(status_bayar=1,denda,IF(DATE_FORMAT(NOW()-INTERVAL 1 MONTH,'%Y%m')=periode AND DATE_FORMAT(NOW(),'%d')<21,0,IF(dkd IN('9000','9001','9002','9003','9090','9100','9110','9120','9130','9200','9210','9220','9230','9300','9310','9320','9400','9410','9420','9430'),15000,10000)))AS dnd,meterai,total,status_bayar AS stat FROM rekening1 WHERE nomor='001989';
