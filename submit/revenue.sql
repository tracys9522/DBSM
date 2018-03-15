--generate revenue for both covered and not covered

create or replace Function generateRevenue(date1 in customerBill.timein%type, date2 in customerBill.timeout%type)
return string is ret varchar(200);
begin
declare
	cursor cur is 
	select coverage, laborhours, cost
	from customerBill
	where timein >= date1 and timeout <= date2;
	l_cur cur%rowtype;

	lcover decimal := 0;
	lncover decimal := 0;
	lcost decimal:= 0;

begin
	for l_cur in cur
	loop
		lcost := 50 + l_cur.cost + 20 * l_cur.laborhours;
		if l_cur.coverage = 'Y' then
			lcover := lcover + lcost;
		else
			lncover := lncover + lcost;
		end if;
	end loop;
	
	--dbms_output.put_line('revenue not covered '||lncover);
	--dbms_output.put_line('revenue covered '||lcover);
	ret := 'revenue not covered: '||lncover||'.'||'revenue covered: '||lcover||'.';

	return ret;
end;
end;
/
show errors;
