create or replace procedure addproblem(
	l_mach in problemReport.machineid%type,
	l_prob in problemReport.problemid%type)
as

begin

		insert into problemReport values(l_mach,l_prob);

end;
/
show errors;
