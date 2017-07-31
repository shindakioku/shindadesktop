import QtQuick 2.7
import QtQuick.Controls 1.4
import QtQuick.Controls.Styles 1.4
import QtQuick.Layouts 1.3

Item {
    id: eachAnimeRoot
    width: 600
    height: 500
    focus: true

    Keys.onEscapePressed: {
        stackView.pop()
    }

    property var animeData

    property bool userHas

    property string animeId

    Component.onCompleted: {
        AnimeService.getEachAnime(animeId)
        UserService.hasFavorite(userId, animeId, "anime")
    }

    BusyIndicator {
        id: busyIndicator
        running: true
    }

    Connections {
        target: AnimeService
        onAnimeReady: {
            eachAnimeRoot.animeData = AnimeService.getAnimeObject()
            busyIndicator.running = false

            if (eachAnimeRoot.animeData.soundtracks)
                for (var i = 0; i < eachAnimeRoot.animeData.soundtracks.length; i++)
                    animeSoundtracksModel.append(eachAnimeRoot.animeData.soundtracks[i])

            if (eachAnimeRoot.animeData.series)
                for (var s = 0; s < eachAnimeRoot.animeData.series.length; s++)
                    animeSeriesModel.append(eachAnimeRoot.animeData.series[s])
        }
    }

    Connections {
        target: UserService
        onNoFavorite: userHas = false
        onIsFavorite: userHas = true
    }

    Item {
        width: 280
        height: 350
        anchors.top: parent.top
        anchors.left: parent.left
        anchors.topMargin: 10
        anchors.leftMargin: 5

        Image {
            width: 260
            height: 260
            source: eachAnimeRoot.animeData ? eachAnimeRoot.animeData.image_url: ""

            MouseArea {
                hoverEnabled: true
                anchors.fill: parent
                onEntered: hoverOnImage.visible = true
                onExited: hoverOnImage.visible = false
            }

            Rectangle {
                id: hoverOnImage
                width: parent.width
                height: parent.height
                visible: false
                color: "#000"
                opacity: 0.7

                Text {
                    anchors.centerIn: parent
                    color: userHas ? "red" : "#fff"
                    font.pixelSize: 30
                    text: "♥"
                }

                MouseArea {
                    anchors.fill: parent
                    onClicked: UserService.addFavorite(userId, userToken, animeId, "anime")
                }
            }
        }

        Rectangle {
            width: 260
            height: 30
            anchors.top: parent.top
            anchors.topMargin: 265
            color: "#607D8B"

            Text {
                anchors.centerIn: parent
                color: "#fff"
                text: eachAnimeRoot.animeData ? eachAnimeRoot.animeData.company.name: ""
            }
        }
    }

    Item {
        width: 310
        height: 350
        anchors.top: parent.top
        anchors.right: parent.right
        anchors.topMargin: 10
        anchors.rightMargin: 5

        Rectangle {
            width: parent.width
            height: 30
            color: "#607D8B"
            radius: 3

            TextMetrics {
                id: titleMetrics
                elideWidth: 300
                elide: Text.ElideRight
                text: eachAnimeRoot.animeData ? eachAnimeRoot.animeData.title : ""
            }

            Text {
                anchors.centerIn: parent
                font.pixelSize: 10
                color: "#fff"
                text: titleMetrics.elidedText
            }
        }

        Item {
            width: parent.width
            height: 30
            anchors.top: parent.top
            anchors.topMargin: 40
            anchors.left: parent.left
            anchors.leftMargin: 5

            Text {
                width: parent.width - 150
                color: "#78909C"
                text: eachAnimeRoot.animeData ? "Дата: " + eachAnimeRoot.animeData.date : ""
            }

            Text {
                width: parent.width - 150
                anchors.right: parent.right
                anchors.rightMargin: -60
                color: "#78909C"
                text: eachAnimeRoot.animeData ? "Статус: " + eachAnimeRoot.animeData.status : ""
            }
        }

        Item {
            width: parent.width
            height: 25
            anchors.top: parent.top
            anchors.topMargin: 65

            Rectangle {
                width: parent.width
                height: 25
                color: "#607D8B"
                radius: 3

                Text {
                    color: "#fff"
                    horizontalAlignment: Text.AlignLeft
                    verticalAlignment: Text.AlignVCenter
                    padding: 6
                    text: eachAnimeRoot.animeData ? eachAnimeRoot.animeData.genres : ""
                }
            }
        }

        Item {
            width: parent.width
            height: 30
            anchors.top: parent.top
            anchors.topMargin: 100
            anchors.left: parent.left
            anchors.leftMargin: 5

            Text {
                width: parent.width - 150
                color: "#78909C"
                text: eachAnimeRoot.animeData ? "Shikimori: " + eachAnimeRoot.animeData.shikimori : ""
            }

            Text {
                width: parent.width - 150
                anchors.right: parent.right
                anchors.rightMargin: -60
                color: "#78909C"
                text: eachAnimeRoot.animeData ? "World-Art: " + eachAnimeRoot.animeData.world_art : ""
            }
        }

        Item {
            width: parent.width
            height: 150
            anchors.top: parent.top
            anchors.topMargin: 130 // 140?
            anchors.left: parent.left

            TextMetrics {
                id: descriptionMetrics
                elideWidth: 3400
                elide: Text.ElideRight
                text: eachAnimeRoot.animeData ? eachAnimeRoot.animeData.description : ""
            }

            Text {
                anchors.fill: parent
                wrapMode: Text.WordWrap
                text: descriptionMetrics.elidedText
            }
        }
    }

    Item {
        width: 250
        height: 130
        anchors.top: parent.top
        anchors.left: parent.left
        anchors.topMargin: 320
        anchors.leftMargin: 20


        Rectangle {
            width: parent.width
            height: 25
            radius: 3
            color: "#4DB6AC"

            Text {
                anchors.centerIn: parent
                color: "#fff"
                text: "Саундтреки"
            }

            MouseArea {
                anchors.fill: parent
                onClicked: {
                    soundPlayer.musicList = eachAnimeRoot.animeData.soundtracks
                    musicPlayerItem.visible = true
                    soundPlayer.justPlay()

                    for (var i = 0; i < eachAnimeRoot.animeData.soundtracks.length; i++)
                    {
                        MusicService.downloadTracks(eachAnimeRoot.animeData.title,
                                                    eachAnimeRoot.animeData.soundtracks[i].name,
                                                    eachAnimeRoot.animeData.soundtracks[i].source)
                    }
                }
            }
        }

        ListModel {
            id: animeSoundtracksModel
        }

        ScrollView {
            height: 100
            anchors.top: parent.top
            anchors.topMargin: 30
            style: ScrollViewStyle {
                handle: Rectangle {
                    implicitWidth: 7
                    implicitHeight: 50
                    color: "#4DB6AC"
                    radius: 4
                }
                scrollBarBackground: Rectangle{
                }
                decrementControl: Rectangle {
                }
                incrementControl: Rectangle {
                }
            }

            ListView {
                width: 250
                model: animeSoundtracksModel
                anchors.fill: parent
                anchors.leftMargin: 15
                clip: true
                spacing: 10

                delegate: Rectangle {
                    color: "#4DB6AC"
                    width: 150
                    height: 20
                    radius: 3
                    anchors.left: parent.left
                    anchors.leftMargin: 30 // 25?

                    Text {
                        anchors.centerIn: parent
                        text: index + 1 + "ый саундтрек"
                        color: "#fff"
                    }
                }
            }
        }
    }

    Item {
        width: 250
        height: 130
        anchors.top: parent.top
        anchors.right: parent.right
        anchors.topMargin: 320
        anchors.rightMargin: 20


        Rectangle {
            width: parent.width
            height: 25
            radius: 3
            color: "#4DB6AC"

            Text {
                anchors.centerIn: parent
                color: "#fff"
                text: "Серии"
            }

            MouseArea {
                anchors.fill: parent
                onClicked: Qt.openUrlExternally("http://shindak.mcdir.ru/public/index.php/program/video-player/" + eachAnimeRoot.animeData.id)
            }
        }

        ListModel {
            id: animeSeriesModel
        }

        ScrollView {
            height: 100
            anchors.top: parent.top
            anchors.topMargin: 30
            style: ScrollViewStyle {
                handle: Rectangle {
                    implicitWidth: 7
                    implicitHeight: 50
                    color: "#4DB6AC"
                    radius: 4
                }
                scrollBarBackground: Rectangle{
                }
                decrementControl: Rectangle {
                }
                incrementControl: Rectangle {
                }
            }

            ListView {
                width: 250
                model: animeSeriesModel
                anchors.fill: parent
                anchors.leftMargin: 15
                clip: true
                spacing: 10

                delegate: Rectangle {
                    color: "#4DB6AC"
                    width: 150
                    height: 20
                    radius: 3
                    anchors.left: parent.left
                    anchors.leftMargin: 35

                    Text {
                        anchors.centerIn: parent
                        text: index + 1 + "ая серия"
                        color: "#fff"
                    }

                    MouseArea {
                        anchors.fill: parent
                        onDoubleClicked: AnimeService.downloadVideo(eachAnimeRoot.animeData.title,
                                                                    index + 1 + "ая серия",
                                                                    source)
                    }
                }
            }
        }
    }
}

