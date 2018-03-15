
drop table problemReport cascade constraints;
drop table customerBill cascade constraints;
drop table singleContract cascade constraints;
drop table groupContract cascade constraints;
drop table repairPerson cascade constraints;
drop table problem cascade constraints;
drop table repairJob cascade constraints;
drop table repairLog;
drop table serviceContract cascade constraints;
drop table repairItem cascade constraints;
drop table customer cascade constraints;


create table customer(
  customerid varchar(5) primary key,
  name varchar(10) not null,
  phoneno integer not null unique
);

create table repairPerson
(
  employeeid varchar(5) primary key,
  name varchar(15) not null,
  phone integer not null
);

create table serviceContract
(
  contractid varchar(5) primary key,
  custphone integer not null unique,
  startdate date,
  enddate date,
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP'))
);

create table singleContract
(
    contractid varchar(5) primary key,
    machineid varchar(5) not null,
    foreign key (contractid) references serviceContract(contractid)
);

create table groupContract
(
    contractid varchar(5) primary key,
    machineid1 varchar(5) not null,
    machineid2 varchar(5) not null,
    foreign key (contractid) references serviceContract(contractid)
);

create table repairItem
(
  itemid varchar(5) primary key,
  custid varchar(5),
  model varchar(10),
  price decimal(10,2),
  year varchar(4),
  item varchar(15),
  check(item in ('COMPUTER','PRINTER')),
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP')),
  foreign key (custid) references customer (customerid)
);

create table repairJob
(
  machineid varchar(5) primary key,
  servicecontractid varchar(5),
  arrivaltime date,
  customerid varchar(5),
  coverage char(1) check(coverage in('Y','N')),
  status varchar(15) not null,
  check (status in('UNDER_REPAIR','READY','DONE')),
  foreign key (servicecontractid) references serviceContract(contractid),
  foreign key (customerid) references customer(customerid),
  foreign key (machineid) references repairItem(itemid)
);

create table repairLog
(
    machineid varchar(5) primary key,
    servicecontractid varchar(5),
    arrivaltime date,
    customerid varchar(5),
    coverage char(1) check(coverage in('Y','N')),
    status varchar(15) default 'DONE',
    foreign key (servicecontractid) references serviceContract(contractid),
    foreign key (customerid) references customer(customerid),
	foreign key (machineid) references repairItem(itemid)
);

create table problem
(
  	problemid varchar(5) primary key,
  	description varchar(20)
);


create table problemReport
(
    machineid varchar(5),
    problemid varchar(5),
	foreign key (problemid) references problem(problemid),
	foreign key (machineid) references repairItem(itemid)
);

create table customerBill
(
  machineid varchar(5) primary key,
  customerid varchar(5),
  employeeid varchar(5),
  problemid varchar(5),
  model varchar(10),
  timein date,
  timeout date,
  laborhours decimal(10,2),
  cost decimal(10,2),
  coverage char(1) check(coverage in('Y','N')),
  foreign key (customerid) references customer(customerid),
  foreign key (machineid) references repairLog(machineid),
  foreign key (employeeid) references repairPerson(employeeid),
  foreign key (problemid) references problem(problemid)
);
