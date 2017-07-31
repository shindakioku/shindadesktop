import QtQuick 2.8
import QtMultimedia 5.8
import QtQuick.Controls 1.4
import QtQuick.Controls.Styles 1.4

Item {
    id: soundPlayerRoot
    width: 600
    height: 50

    property var musicList: []

    onMusicListChanged: {
        if(1 == musicList.length)
            audioRootPlaylist.addItem(musicList[0].source)
        else
            for (var i = 0; i < musicList.length; i++)
                audioRootPlaylist.addItem(musicList[i].source)

    }

    function justPlay()
    {
        audioRoot.play()
    }

    // Music time
    Shortcut {
        sequence: "z"
        onActivated: audioRoot.seek(audioRoot.position - 400)
    }

    Shortcut {
        sequence: "x"
        onActivated: audioRoot.seek(audioRoot.position + 400)
    }

    // Stop | Play
    Shortcut {
        sequence: "Space"
        onActivated: {
            if (0 !== audioRootPlaylist.columnCount())
                audioRoot.playbackState === MediaPlayer.PlayingState ? audioRoot.pause() : audioRoot.play()
        }
    }

    // Volume
    Shortcut {
        sequence: "c"
        onActivated: audioRoot.volume -= 0.1
    }

    Shortcut {
        sequence: "v"
        onActivated: audioRoot.volume += 0.1
    }

    Shortcut {
        sequence: "b"
        onActivated: audioRoot.volume = 0 !== audioRoot.volume ? 0 : 0.2
    }

    // Next | Back
    Shortcut {
        sequence: "n"
        onActivated: audioRootPlaylist.previous()
    }

    Shortcut {
        sequence: "m"
        onActivated: audioRootPlaylist.next()
    }

    Audio {
        id: audioRoot
        playlist: Playlist {
            id: audioRootPlaylist
        }

        volume: 0.1

        onPositionChanged: {
            musicTimeSlider.value = audioRoot.position
        }
    }

    Text {
        anchors.top: parent.top
        anchors.left: parent.left
        anchors.topMargin: 15
        anchors.leftMargin: 5
        color: "#fff"
        text: musicPosition(audioRoot.position)
    }

    Slider {
        id: musicTimeSlider
        width: 200
        anchors.top: parent.top
        anchors.left: parent.left
        anchors.topMargin: 15
        anchors.leftMargin: 45
        maximumValue: audioRoot.duration
        stepSize: 1

        onValueChanged: {
            audioRoot.seek(value)
        }

        style: SliderStyle {
            groove: Rectangle {
                width: musicTimeSlider.width
                height: 10
                color: "#58727F"
                radius: 12
            }

            handle: Rectangle {
                anchors.centerIn: parent
                color: control.pressed ? "#fff" : "#466575"
                implicitWidth: 16
                implicitHeight: 16
                radius: 16
            }
        }
    }

    Text {
        anchors.top: parent.top
        anchors.left: parent.left
        anchors.topMargin: 15
        anchors.leftMargin: 250
        color: "#fff"
        text: musicPosition(audioRoot.duration - audioRoot.position)
    }

    Item {
        width: 100
        anchors.left: parent.left
        anchors.top: parent.top
        anchors.topMargin: 5
        anchors.leftMargin: 340 // 370

        Text {
            color: "#fff"
            font.pixelSize: 9
            text: musicList[0] ? musicList[audioRootPlaylist.currentIndex].name : ""
        }

        Item {
            anchors.fill: parent
            anchors.topMargin: 15

            Image {
                source: "music/minus.svg"

                MouseArea {
                    anchors.fill: parent
                    onClicked: {
                        if (0 != audioRoot.volume)
                            audioRoot.volume -= 0.1
                    }
                }
            }

            Image {
                anchors.left: parent.left
                anchors.leftMargin: 25
                source: "music/plus.svg"

                MouseArea {
                    anchors.fill: parent
                    onClicked: {
                        if (1 != audioRoot.volume)
                            audioRoot.volume += 0.1
                    }
                }
            }

            Image {
                anchors.left: parent.left
                anchors.leftMargin: 55
                source: 0 === audioRoot.volume ? "music/no_volume.svg" : "music/volume.svg"

                MouseArea {
                    anchors.fill: parent
                    onClicked: {
                        if (0 != audioRoot.volume)
                            audioRoot.volume = 0
                        else
                            audioRoot.volume = 0.2
                    }
                }
            }
        }
    }

    Item {
        anchors.top: parent.top
        anchors.right: parent.right
        anchors.topMargin: 13
        anchors.rightMargin: 20

        Image {
            source: "music/next.svg"

            MouseArea {
                anchors.fill: parent
                onClicked: audioRootPlaylist.next()
            }
        }

        Image {
            anchors.right: parent.right
            anchors.rightMargin: 10
            source: audioRoot.playbackState === MediaPlayer.PlayingState ? "music/pause.svg" : "music/play.svg"

            MouseArea {
                anchors.fill: parent
                onClicked: {
                    if (0 !== audioRootPlaylist.columnCount())
                        audioRoot.playbackState === MediaPlayer.PlayingState ? audioRoot.pause() : audioRoot.play()
                }
            }
        }

        Image {
            anchors.right: parent.right
            anchors.rightMargin: 40
            source: "music/back.svg"

            MouseArea {
                anchors.fill: parent
                onClicked: audioRootPlaylist.previous()
            }
        }
    }

    function musicPosition(milli)
    {
        var milliseconds = milli % 1000;
        var seconds = Math.floor((milli / 1000) % 60);
        var minutes = Math.floor((milli / (60 * 1000)) % 60);

        if (1 === minutes.toString().length)
            minutes = '0' + minutes

        if (1 === seconds.toString().length)
            seconds = '0' + seconds

        return minutes + ':' + seconds
    }
}
