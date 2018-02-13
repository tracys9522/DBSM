create table customer(
  custid varchar(5) primary key,
  name varchar(10),
  phoneno int
);

create table servicecontract
(
  contracteid varchar(5) primary key,
  machineid varchar(5),
  startdate date,
  enddate date,
  custinfo varchar(100)
);

create table repairjob
(
  machienid varchar(5),
  servicecontractid varchar(5),
  arrivaltime datetime,
  ownerinfo varchar(100),
  status varchar(15) not null,
  check (status in('UNDER_REPAIR','READY','DONE'))
);
