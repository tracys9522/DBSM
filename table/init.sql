drop table customerBill;
drop table repairJob;
drop table customer;
drop table repairItem;
drop table serviceContract;
drop table problemReport;
drop table repairPerson;

create table customer(
  customerid varchar(5) primary key,
  name varchar(10),
  phoneno char(10) unique
);

create table repairItem
(
  itemid varchar(5) primary key,
  model varchar(10),
  price decimal(10,2),
  year varchar(4),
  item varchar(15),
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP')),
  check(item in ('computer','printer'))
);


create table serviceContract
(
  contractid varchar(5) primary key,
  machineid varchar(5),
  startdate date,
  enddate date,
  customerinfo varchar(100),
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP'))
);

create table repairJob
(
  machineid varchar(5) primary key,
  servicecontractid varchar(5),
  arrivaltime timestamp,
  ownerinfo varchar(100),
  status varchar(15) not null,
  check (status in('UNDER_REPAIR','READY','DONE')),
  foreign key (machineid) references repairItem(itemid),
  foreign key (servicecontractid) references serviceContract(contractid)
);

create table problemReport
(
  problemid varchar(5) primary key,
  problemcode varchar(100)
);

create table repairPerson
(
  employeeNo varchar (5) primary key,
  name varchar(15),
  phone char(10)
);

create table customerBill
(
  machineid varchar(5) primary key,
  model varchar(15),
  customerName varchar(10),
  phoneNo varchar(10),
  timein timestamp,
  timeout timestamp,
  problemid varchar(5),
  repairpersonid varchar(5),
  laborhours decimal(10,2),
  cost number(10,2),
  foreign key (repairpersonid) references repairPerson(employeeNo),
  foreign key (problemid) references problemReport(problemid)
);
