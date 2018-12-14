#!/bin/bash
function getLastModifyFile()
{
last_modify=0
for file in ./*
do
        if test -d $file ;then
                file_modify=`stat "${file}"|grep -i Modify | awk -F. '{print $1}' | awk '{print $2$3}'| awk -F- '{print $1$2$3}' | awk -F: '{print $1$2$3}'`
#                echo $file_modify
                if [ $file_modify -gt $last_modify ]
                then
                last_modify=$file_modify
                lastmfile=$file
                fi
         fi
done
echo ${lastmfile}
return 1
}
lastmfile=`getLastModifyFile`
echo $lastmfile