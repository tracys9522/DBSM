create or replace procedure checkcoverage(l_contract in serviceContract.contractid%type,l_machine in repairJob.machineid%type)
as
	l_coverage repairJob.coverage%type;
	l_enddate serviceContract.enddate%type;
	l_arrive repairJob.arrivaltime%type;

begin

		select arrivaltime
		into l_arrive
		from repairJob
		where machineid = l_machine;

		select enddate 
		into l_enddate 
		from serviceContract 
		where contractid = l_contract;

		if l_arrive <= l_enddate then 
			update repairJob
			set coverage = 'Y'
			where machineid = l_machine;	
		end if;
end;
/
show errors;
