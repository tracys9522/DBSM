create table customer(
  custid varchar(5) primary key,
  name varchar(10),
  phoneno char(10) unique
);

create table repairItem
(
  itemid varchar(5),
  model varchar(10),
  price decimal(10,2),
  year varchar(4),
  serviceContractType varchar(6) default 'NONE',
  check(serviceContractType in ('NONE','SINGLE','GROUP'))
);


create table serviceContract
(
  contracteid varchar(5) primary key,
  machineid varchar(5),
  startdate date,
  enddate date,
  custinfo varchar(100)
);

create table repairJob
(
  machineid varchar(5),
  servicecontractid varchar(5),
  arrivaltime datetime,
  ownerinfo varchar(100),
  status varchar(15) not null,
  check (status in('UNDER_REPAIR','READY','DONE'))
);
