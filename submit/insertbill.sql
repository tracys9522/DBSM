create or replace procedure addbill(
	l_mach in customerBill.machineid%type,
	l_prob in customerBill.problemid%type,
	l_emp in customerBill.employeeid%type,
	l_cost in customerBill.cost%type,
	l_hour in customerBill.laborhours%type,
	l_out in customerBill.timeout%type
	)
as
	l_cust customerBill.customerid%type;
	l_coverage customerBill.coverage%type;
	l_model customerBill.model%type;
	l_in customerBill.timein%type;

begin

	select coverage,arrivaltime
	into l_coverage,l_in
	from repairLog
	where machineid = l_mach;

	select model,custid
	into l_model,l_cust
	from repairItem
	where itemid = l_mach;

	insert into customerBill values(l_mach,l_cust,l_emp,l_prob,l_model,l_in,l_out,l_hour,l_cost,l_coverage);

end;
/
show errors;
