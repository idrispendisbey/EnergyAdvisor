function [ NewX ] = Transformation_binaire( X )
%UNTITLED Summary of this function goes here
%   Detailed explanation goes here


index_jour = X( : , size(X , 2) );
X = X( : , 1 : size(X , 2) - 1 );

NewX = [];
for i = 1 : size(X , 1)  
    
    jour_binaire = zeros( 1 , 7 );
    jour_binaire( 1 , index_jour( i ) ) = 1;
    NewX = [ NewX ; [ X( i , : ) , jour_binaire ] ];
    
end


end
