-- show status of the machine
--set serveroutput on;
create or replace Function showStatus(l_machineid in repairJob.machineid%type)
return string is retval varchar(100);
begin
declare
	l_status repairJob.status%type;
begin
	
	select status
	into l_status
	from repairJob
	where machineid = l_machineid;

	--dbms_output.put_line(l_machineid||' with status: '|| l_status);

	retval := 'machineid '||l_machineid||' with status: '||l_status;

	return retval;
end;
end;
/
show errors;
