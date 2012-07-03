#!/bin/sh
for filename in $(find $1); do
if [ -f $filename ]; then

# 変更対象のファイル名を画面表示
basename $filename |grep -q '[[:upper:]]' 2> /dev/null && basename $filename

# ファイル名の変更
basename $filename |grep -q '[[:upper:]]' 2> /dev/null \
&& mv -i $filename $(echo $filename | tr 'A-Z' 'a-z')

fi
done
