drop table customerBill;
drop table repairJob;
drop table singleContract;
drop table groupContract;
drop table serviceContract;
drop table problemReport;
drop table problem;
drop table repairPerson;
drop table repairItem;
drop table customer;

create table customer(
  customerid varchar(5) primary key,
  name varchar(10) not null,
  phoneno char(10) not null unique
);

create table repairPerson
(
  employeeNo varchar(5) primary key,
  name varchar(15) not null,
  phone char(10) not null
);

create table serviceContract
(
  contractid varchar(5) primary key,
  custphone varchar(10) not null unique,
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
  custid varchar(5) not null,
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
  arrivaltime timestamp,
  ownerinfo varchar(100),
  status varchar(15) not null,
  check (status in('UNDER_REPAIR','READY','DONE')),
  foreign key (machineid) references repairItem(itemid),
  foreign key (servicecontractid) references serviceContract(contractid)
);

create table problem
(
  problemid varchar(5) primary key,
  description varchar(10)
);

create table problemReport
(
    machineid varchar(5) primary key,
    problemid varchar(5),
    foreign key (problemid) references problem(problemid),
    foreign key (machineid) references repairItem(itemid)
);
create table customerBill
(
  machineid varchar(5) primary key,
  model varchar(10),
  customerName varchar(10),
  phoneNo varchar(10),
  timein timestamp,
  timeout timestamp,
  problemid varchar(5),
  repairpersonid varchar(5),
  laborhours decimal(10,2),
  cost number(10,2),
  coverage char(1) check(coverage in('Y','N')),
  foreign key (machineid) references repairItem(itemid),
  foreign key (repairpersonid) references repairPerson(employeeNo),
  foreign key (problemid) references problem(problemid)
);
