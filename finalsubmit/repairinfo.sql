--bill infomation
create or replace Function repairinfo(l_machineid in repairLog.machineid%type)
return string is ret varchar(500);
begin
declare
	
	l_out customerBill.timeout%type;
	l_model customerBill.model%type;
	l_arrive repairLog.arrivaltime%type;
	l_status repairLog.status%type;
	l_coverage repairLog.coverage%type;

begin

	select model, timeout
	into l_model, l_out
	from customerBill
	where machineid = l_machineid;


	select arrivaltime, coverage, status
	into l_arrive, l_coverage, l_status
	from repairLog
	where machineid = l_machineid;

	ret := l_model||' '||l_arrive||' '||l_out||' '||l_coverage||' '||l_status||chr(13);

	return ret;

end;
end;
/ 
show errors;
