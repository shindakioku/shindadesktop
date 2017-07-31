import QtQuick 2.7
import QtQuick.Controls 2.2
import QtQuick.Layouts 1.3
import AnimeModel 1.0

Item {
    width: 600
    height: 500
    focus: true

    Keys.onLeftPressed: {
        if (0 === skip)
            return;

        skip -= 4;
    }

    Keys.onRightPressed: {
        if (noData)
            return;

        skip = 0 === skip ? 4 : skip += 4
    }

    property string textForHeader: "Список аниме"

    property int indexHeader: 0

    property int skip: 0
    property int take: 4

    property bool noData: false

    BusyIndicator {
        id: busyIndicator
        running: 0 == indexHeader
    }

    AnimeModel {
        id: animeModel

        url: "get-anime?skip=" + skip + "&take=" + take

        onAnimeReadyForQml: {
            busyIndicator.running = false
            noData = false
        }

        onNoMoreData: {
            noData = true
        }
    }

    Shortcut {
        sequence: "1"
        onActivated: {
            var id = animeModel.get(0, 257)

            if (undefined !== id)
                stackView.push(eachAnimePageComponent, {animeId: id})
        }
    }

    Shortcut {
        sequence: "2"
        onActivated: {
            var id = animeModel.get(1, 257)

            if (undefined !== id)
                stackView.push(eachAnimePageComponent, {animeId: id})
        }
    }

    Shortcut {
        sequence: "3"
        onActivated: {
            var id = animeModel.get(2, 257)

            if (undefined !== id)
                stackView.push(eachAnimePageComponent, {animeId: id})
        }
    }

    Shortcut {
        sequence: "4"
        onActivated: {
            var id = animeModel.get(3, 257)

            if (undefined !== id)
                stackView.push(eachAnimePageComponent, {animeId: id})
        }
    }

    GridView {
        model: animeModel
        anchors.fill: parent
        width: 450
        height: 350
        anchors.topMargin: 20
        anchors.leftMargin: 90
        anchors.rightMargin: 60
        clip: true
        cellWidth: 220
        cellHeight: 220

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
                    duration: 500 // 700 ?
                }
            }
        }

        delegate: Image {
            width: 200
            height: 200
            source: image

            MouseArea {
                anchors.fill: parent
                hoverEnabled: true
                onEntered: onHoveredImage.visible = true
                onExited: onHoveredImage.visible = false
                onClicked: stackView.push(eachAnimePageComponent, {animeId: id})
            }

            Rectangle {
                visible: false
                id: onHoveredImage
                anchors.fill: parent
                color: "#000"
                opacity: 0.6

                Text {
                    wrapMode: Text.WordWrap
                    anchors.fill: parent
                    padding: 5
                    color: "#fff"
                    font.pixelSize: 14
                    text: name
                }
            }
        }
    }
}
