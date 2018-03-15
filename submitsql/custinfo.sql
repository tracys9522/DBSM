--bill infomation
create or replace Function custinfo(l_machineid in repairLog.machineid%type)
return string is ret varchar(500);
begin
declare
	l_custname customer.name%type;
	l_custphone customer.phoneno%type;
	l_custid customerBill.customerid%type;
begin

	select customerid
	into l_custid
	from customerBill
	where machineid = l_machineid;

	select name, phoneno
	into l_custname, l_custphone
	from customer
	where customerid = l_custid;
	
	ret := l_custname||' '||l_custphone;

return ret;
end;
end;
/ 
show errors;
