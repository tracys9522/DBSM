--bill infomation
create or replace Function probinfo(l_machineid in repairLog.machineid%type)
return string is ret varchar(500);
begin
declare
	l_problem customerBill.problemid%type;
	l_description problem.description%type;

begin
	select problemid
	into l_problem
	from customerBill
	where machineid = l_machineid;

	select description
	into l_description
	from problem
	where problemid = l_problem;

	ret := l_problem ||': '||l_description;

return ret;
end;
end;
/ 
show errors;
