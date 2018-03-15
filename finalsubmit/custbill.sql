--bill is created for each repair job
set serveroutput on;
create or replace Function generateBill(l_machineid in repairLog.machineid%type)
return string is ret varchar(100);
begin
declare

	l_cost customerBill.cost%type;
	l_hours customerBill.laborhours%type;
	l_coverage repairLog.coverage%type;

	total decimal := 0;
begin

	select laborhours, cost
	into l_hours, l_cost
	from customerBill
	where machineid = l_machineid;

	select coverage
	into l_coverage
	from repairLog
	where machineid = l_machineid;

	if l_coverage = 'N' then
		total := 50 + l_cost + 20* l_hours;
	else 
		total := 0;
	end if;

	ret := 'total amount: $'||total;

end;
return ret;
end;
/ 
show errors;
