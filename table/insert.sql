insert into customer values('cust1','smith',4084010000);
insert into customer values('cust2','yeehee',4084010001);
insert into customer values('cust3','green',4084010002);

insert into serviceContract values('sc1',4084010000,date'2017-12-12',date'2019-01-16','SINGLE');
insert into serviceContract values('sc2',4084010001,date'2016-01-02',date'2020-01-01','GROUP');
insert into serviceContract values('sc3',4084010002,date'2015-12-01',date'2017-01-05','SINGLE');

insert into singleContract values('sc1','m1');
insert into singleContract values('sc3','m3');

insert into groupContract values('sc2','m4','m2');

insert into problem values('p1','software outdated');
insert into problem values('p2','parts replacement');
insert into problem values('p3','virus attack');
insert into problem values('p4','damaged');

insert into repairPerson values('e1','john',4084010004);
insert into repairPerson values('e2','jaime',4084010005);
insert into repairPerson values('e3','jack',4084010006);

insert into repairItem values('i1','cust1','lenovo',2000,'2015','COMPUTER','SINGLE');
insert into repairItem values('i2','cust3','asus',900,'2015','COMPUTER','SINGLE');
