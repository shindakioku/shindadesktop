import QtQuick 2.7
import QtQuick.Controls 2.0
import QtQuick.Layouts 1.3
import MusicModel 1.0

Item {
    Keys.onLeftPressed:{
        if (0 === skip)
            return;

        skip -= 12;

    }

    Keys.onRightPressed: {
        if (noData)
            return;

        skip = 0 === skip ? 12 : skip += 12
    }

    property string textForHeader: "Список музыки"

    property int indexHeader: 1

    property int skip: 0
    property int take: 12

    property var musicDataOfPage: []

    property bool noData: false

    BusyIndicator {
        id: busyIndicator
        running: 0 == indexHeader
    }

    MusicModel {
        id: musicModel

        url: "music?skip=" + skip + "&take=" + take

        onMusicReadyForQml: {
            busyIndicator.running = false
            noData = false
        }

        onNoMoreData: {
            noData = true
        }
    }

    Rectangle {
        width: 295
        height: 35
        anchors.top: parent.top
        anchors.left: parent.left
        color: "#90A4AE"

        Text {
            color: "#fff"
            anchors.centerIn: parent
            text: "Слушать все"
        }

        MouseArea {
            hoverEnabled: true
            anchors.fill: parent
            onEntered: parent.color = "#607D8B"
            onExited: parent.color = "#90A4AE"
            onClicked: {
                if (0 !== musicDataOfPage.length)
                {
                    soundPlayer.musicList = musicDataOfPage
                    musicPlayerItem.visible = true
                    soundPlayer.justPlay()
                }
            }
        }
    }

    Rectangle {
        width: 295
        height: 35
        anchors.top: parent.top
        anchors.right: parent.right
        color: "#90A4AE"

        Text {
            color: "#fff"
            anchors.centerIn: parent
            text: "Скачать все"
        }

        MouseArea {
            hoverEnabled: true
            anchors.fill: parent
            onEntered: parent.color = "#607D8B"
            onExited: parent.color = "#90A4AE"
            onClicked: {
                if (0 !== musicDataOfPage.length)
                    for(var i = 0; i < musicDataOfPage.length; i++)
                        MusicService.download(musicDataOfPage[i].name, musicDataOfPage[i].source)
            }
        }
    }

    GridView {
        model: musicModel
        anchors.fill: parent
        width: 450
        height: 350
        anchors.topMargin: 50
        anchors.leftMargin: 70 // 90
        anchors.rightMargin: 30
        clip: true
        cellWidth: 250
        cellHeight: 60

        add: Transition {
            ParallelAnimation {
                NumberAnimation {
                    properties: "opacity"
                    from: 0
                    to: 1
                    duration: 500
                }
                NumberAnimation {
                    properties: "x, y"
                    from: 100
                    duration: 700
                }
            }
        }

        delegate: Rectangle {
            width: 200
            height: 30
            radius: 2
            color: "#90A4AE"

            Component.onCompleted: {
                musicDataOfPage[index] = {
                    name: name,
                    source: source
                }
            }

            Text {
                anchors.centerIn: parent
                color: "#fff"
                text: name
            }

            MouseArea {
                hoverEnabled: true
                anchors.fill: parent
                onEntered: parent.color = "#607D8B"
                onExited: parent.color = "#90A4AE"
                onClicked: {
                    soundPlayer.musicList = [musicDataOfPage[index]]
                    musicPlayerItem.visible = true
                    soundPlayer.justPlay()
                }
            }
        }
    }
}
