--change status of the repair job
create or replace procedure updateStatus(l_machineid in repairJob.machineid%type, l_status in repairJob.status%type)
as
	l_contract repairJob.servicecontractid%type;
	l_arrive repairJob.arrivaltime%type;
	l_cust	repairJob.customerid%type;
	l_coverage repairJob.coverage%type;

begin
	select servicecontractid,arrivaltime,customerid,coverage
	into l_contract,l_arrive,l_cust,l_coverage
	from repairJob
	where machineid = l_machineid;

    if l_status = 'DONE' then
		delete from repairJob where machineid = l_machineid;
        insert into repairLog values(l_machineid,l_contract,l_arrive,l_cust,l_coverage,'DONE');
    else
	    update repairJob
	    set status = upper(l_status)
	    where machineid = l_machineid;
    end if;
end;
/
show errors;
