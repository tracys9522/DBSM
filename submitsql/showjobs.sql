--show repair jobs are under repair and days they are bought in
create or replace Function showRepairJobs(l_mach in repairJob.machineid%type)
return string is ret varchar(100);
begin
declare

	l_time repairJob.arrivaltime%type;
	l_days number;

begin
	
	select arrivaltime
	into l_time
	from repairJob
	where machineid = l_mach;

	l_days := to_date(sysdate) - to_date(l_time);
	ret := l_days||' days since brought in';	
	
	return ret;
end; 
end;
/
show errors;
