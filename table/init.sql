drop sequence cid;
drop sequence riid;
drop sequence scid;
drop sequence rjid;
drop sequence prid;
drop sequence rpid;
drop table customerBill;
drop table repairJob;
drop table customer;
drop table serviceContract;
drop table problemReport;
drop table repairPerson;
drop table repairItem;

create table customer(
  customerid INTEGER,
  name varchar(10),
  phoneno char(10) unique,
  primary key(customerid)
);

create sequence cid
start with 1
increment by 1
cache 50;

create or replace trigger customer_increment
before insert on customer
for each row
begin
	select cid.nextval
	into :new.customerid
	from dual;
end;
/
Show errors; 


create table repairItem
(
  itemid INTEGER,
  model varchar(10),
  price decimal(10,2),
  year varchar(4),
  item varchar(15),
  serviceContractType varchar(6) default 'NONE',
  check(item in ('COMPUTER','PRINTER')),
  check(serviceContractType in ('NONE','SINGLE','GROUP')),
  primary key(itemid)
);

create sequence riid
start with 1
increment by 1
cache 50;

create or replace trigger repairItem_increment
before insert on repairItem
for each row
begin
	select riid.nextval
	into :new.itemid
	from dual;
end;
/
Show errors; 

create table serviceContract
(
  contractid  INTEGER,
  machineid varchar(10),
  startdate date,
  enddate date,
  customerinfo varchar(100),
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP')),
  primary key(contractid)
);

create sequence scid
start with 1
increment by 1
cache 50;

create or replace trigger serviceContract_increment
before insert on serviceContract
for each row
begin
	select scid.nextval
	into :new.contractid
	from dual;
end;
/
Show errors; 

create table repairJob
(
  machineid INTEGER primary key,
  servicecontractid INTEGER,
  arrivaltime timestamp,
  ownerinfo varchar(100),
  status varchar(15) not null,
  check (status in('UNDER_REPAIR','READY','DONE')),
  foreign key (machineid) references repairItem(itemid),
  foreign key (servicecontractid) references serviceContract(contractid)
);

create sequence rjid
start with 1
increment by 1
cache 50;

create or replace trigger repairJob_increment
before insert on repairJob
for each row
begin
	select rjid.nextval
	into :new.servicecontractid
	from dual;
end;
/
Show errors; 

create table problemReport
(
  problemid INTEGER primary key,
  problemcode varchar(10),
  foreign key (problemid) references repairItem(itemid)
);

create sequence prid
start with 1
increment by 1
cache 50;

create or replace trigger problemReport_increment
before insert on problemReport
for each row
begin
	select prid.nextval
	into :new.problemid
	from dual;
end;
/
Show errors; 

create table repairPerson
(
  employeeNo INTEGER,
  name varchar(15),
  phone char(10),
  primary key (employeeNo)
);

create sequence rpid
start with 1
increment by 1
cache 50;

create or replace trigger repairPerson_increment
before insert on repairPerson
for each row
begin
	select rpid.nextval
	into :new.employeeNo
	from dual;
end;
/
Show errors; 

create table customerBill
(
  machineid varchar(5) primary key,
  model varchar(15),
  customerName varchar(10),
  phoneNo varchar(10),
  timein timestamp,
  timeout timestamp,
  problemid INT,
  repairpersonid INT,
  laborhours decimal(10,2),
  cost number(10,2),
  foreign key (repairpersonid) references repairPerson(employeeNo),
  foreign key (problemid) references problemReport(problemid)
);
