#!/bin/zsh

FILE=/tmp/play
YFILE=/tmp/youtube
STOPFILE=/tmp/stop

while (true) {
    sleep 3;
    if [[ -a $STOPFILE ]] {
        rm -f $STOPFILE
#        echo "killing" >> /tmp/rpmc.log
        killall omxplayer.bin
    }
    if [[ -a $YFILE ]] {
        URL=`cat $YFILE`
        rm -f $YFILE
#        echo "downlaoding $URL ..." >> /tmp/rpmc.log
        youtube-dl -g $URL > $FILE
    }
    if [[ -a $FILE ]] {
        VIDEO=`cat $FILE`
        rm -f $FILE
#        echo "playing $VIDEO ..." >> /tmp/rpmc.log
        omxplayer $VIDEO
        echo "$VIDEO finished"
        unset VIDEO
    }
}
