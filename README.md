COEN 178 Project
Fast Repairs Inc.

About
Fast Repairs Inc. is a computer repair shop specializing in computer and printer repairs. Our system helps track the records on maintenance of the repair jobs and generate useful information. On the customer side, this system accepts new customers with repair items for their machines, as well as the returning customers who have a service contract. On the repair shop side, this system allows employees to update and show the repair status for the machine, generate bills for customer, as well as generate revenue for the company. The site was developed with HTML while PHP was used to collect information from the HTML forms and feed them into the Oracle database with tables created using SQL.

ER Diagram
	In Project_ER_Diagram.pdf

Functional Dependencies 

customer(customerId, name, phoneNo)
FD: customerId →name, phoneNo
This relation is BCNF. The closure of customerId contains all attributes.

repairPerson(employeeid, name, phone)
FD: employeeid →name, phone
This relation is BCNF. The closure of employeeid contains all attributes.

serviceContract(contractid, custphone, startdate, enddate, serviceContractType)
FD: contractid→custphone, startdate, enddate, serviceContractType
This relation is BCNF. The closure of contractid contains all attributes.

singleContract(contractid, machineid)
FD: contractid→machineid
This relation is BCNF. The closure of contractid contains all attributes.

groupContract(contractid, machineid1, machineid2)
FD: contractid→machineid1, machineid2
This relation is BCNF. The closure of contractid contains all attributes.

repairItem(itemid, custid, model, price, year, item, serviceContractType)
FD: itemid→custid, model, price, year, item, serviceContractType
This relation is BCNF. The closure of itemid contains all attributes.

repairJob(machineid, servicecontractid, customerid, arrivaltime, coverage, status)
FD: machineid→servicecontractid, customerid, arrivaltime, coverage, status
This relation is in BCNF. The closure of machineid contains all attributes.
If endtime was an attribute in repairJob, ‘coverage’ and ‘status’ would be determined by ‘servicecontractid’, ‘arrivaltime’, and ‘endtime’

repairLog(machineid,servicecontractid, customerid, arrivaltime, coverage, status)
FD: machineid→servicecontractid, customerid, arrivaltime, coverage, status
This relation is in BCNF. The closure of machineid contains all attributes

problem(problemid, description)
FD: problemid→description
This relation is in BCNF. The closure of problemid contains all attributes.
	
problemReport(machineid, problemid)
FD: machineid→problemid
This relation is in BCNF. The closure of machineid contains all attributes.

customerbill(machineid, customerid, employeeid, model, timein, timeout, laborhours, cost, coverage)
FD: machineid→customerid, employeeid, model, timein, timeout, laborhours, cost, coverage
FD: timein, timeout→laborhours, cost, coverage
This relation is not in BCNF. While machineid contains all attributes, ‘timein, timeout’ does not. This relation is also not in 3NF.

Tables

	Primary Key 
	Foreign Key

	customer(customerId, name, phoneNo)

	repairPerson(employeeid, name, phone)

	serviceContract(contractid, custphone, startdate, enddate, serviceContractType)

	singleContract(contractid, machineid)

	groupContract(contractid, machineid1, machineid2)

	repairItem(itemid, custid, model, price, year, item, serviceContractType)

	repairJob(machineid, servicecontractid, customerid, arrivaltime, coverage, status)

	repairLog(machineid,servicecontractid, customerid, arrivaltime, coverage, status)

	problem(problemid, description)

	problemReport(machineid, problemid)

	customerbill(machineid, customerid, employeeid, model, timein, timeout, 
         laborhours, cost, coverage)



SQL, PLSQL, PHP, HTML


Our HTML and PHP files are in the submitfront folder while our SQL files are in submitback.
Submitfront contains:

addbill.html and addbill.php
This pages allows the repair shop to generate a bill for a finished job by entering the needed information into the required fields.

addproblem.html and addproblem.php
This page allows the repair shop to add a problem ID to an item being repaired.

bill.html and bill.php
This page has the repair shop enter in the machine id for the repair job that which will then show the bill for the job.

cStatus.html and cStatus.php
This page allows the customer to check the repair status of the item they submitted for repair.

customer.html and customer.php
This page is for the customer to submit their information or “register” with the website before they submit an item for repair.

done.html
This page appears after an item has been approved for repair. It provides the link to cStatus.

Employee.html
This is the main page for the repair shop and contains the links to see the items currently being repaire, have been repaired, update the status of a repair job, generate the bill, and generate revenue.

repair.html and repair.php
This page is for the customer to submit an item for repair by filling out the required fields.

repair2.html and repair2.php
This page is for the customer to submit a second item for repair.

repairlog.php
This page shows the repair shop the repair jobs with the status ‘DONE’. Once a repair job’s status is changed to ‘DONE’, it is moved from the repair job page to the repair log page.

revenue.html and revenue.php
This page has the repair shop enter two dates and shows the revenue generated between the dates.

showjob.php
This page shows the jobs currently under repair.

showstatus.html and showstatus.html
This page shows the status of the repair jobs.

update.html and update.php
This page allows the repair shop to change the status of a repair job to ‘READY’ or ‘DONE’. ‘READY’ will redirect the user to add problem ids to the repair job while ‘DONE’ redirects the user to the add bill page.

Submitback contains:

checkCoverage.sql
Contains a procedure that checks whether an item is covered by its service contract

custbill.sql
Contains a function that calculates the cost of the repair job

custinfo.sql
Contains a function that displays the customer information

drop.sql
This file drops all the tables created

insert.sql
This file populates the tables, adding old customers, service contracts, employee information, and problem ids into the system

insertbill.sql
Contains a procedure that populates information into the customer bill

insertprob.sql
Contains a procedure that inserts problems into the problem report

repairinfo.sql
Contains a function that generates information about a repair job

revenue.sql
Contains a function that generates the revenue based on the dates provided

showjobs.sql
Contains a function that calculates number of days since the machine has been brought into the shop

showstatus.sql
Contains a function that shows the status of repair jobs

table.sql
This file contains all the database tables used by the website

updatestatus.sql
Contains a procedure that determines what is done to a repair job based on what its status is updated to

Assumptions

Itemid and machineid are the same thing.
When inserting a new repair item, all machine status are predefined as “UNDER_REPAIR”.
Add problems to the machine when updating the status into “READY”.
Add a new bill when updating machine status into “DONE”.
