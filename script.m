A  = rand(50,1);
B = rand(50,1);
fid=fopen('output.txt','w');
fprintf(fid, 'raw data generated by matlab\n');
fprintf(fid, '%f %f \n', [A B]');
fclose(fid);
