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

create table repairItem
(
  itemid INTEGER,
  model varchar(10),
  price decimal(10,2),
  year varchar(4),
  item varchar(15),
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP')),
  check(item in ('COMPUTER','PRINTER')),
  primary key(itemid)
);


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

create table problemReport
(
  problemid INTEGER primary key,
  problemcode varchar(10),
  foreign key (problemid) references repairItem(itemid)
);

create table repairPerson
(
  employeeNo INTEGER,
  name varchar(15),
  phone char(10),
  primary key (employeeNo)
);

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
