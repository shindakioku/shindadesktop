import QtQuick 2.8
import QtQuick.Window 2.2
import QtQuick.Layouts 1.3
import QtQuick.Controls 2.1
import QtQuick.Controls.Styles 1.4
import "anime"
import "music"
import "user"
import "players"

ApplicationWindow {
    id: appWindow
    width: 600
    height: 500
    maximumWidth: 600
    maximumHeight: 500

    x: Screen.width / 2 - width / 2
    y: Screen.height / 2 - height / 2

    background: Image {
        id: appBackground
    }

    property var componentsForHeader: [
        animePageComponent,
        musicPageComponent,
    ]

    function arrowsForHeader(index) {
        var next = index
        var prev = index

        if (undefined !== componentsForHeader[next + 1]) {
            headerNextComponent.indexComponentNext = next + 1
            headerNextComponent.visible = true
        }
        else
            headerNextComponent.indexComponentNext = 999

        if (0 !== prev && undefined !== componentsForHeader[prev - 1]) {
            headerForwardComponent.indexComponentForward = prev - 1
            headerForwardComponent.visible = true
        }
        else
            headerForwardComponent.indexComponentForward = 999
    }

    visible: true

    title: qsTr("Shinda")

    Item {
        z: 99
        id: musicPlayerItem
        visible: false
        width: 600
        height: 40
        anchors.bottom: parent.bottom
        anchors.left: parent.left

        Rectangle {
            id: musicPlayerItemMain
            anchors.fill: parent
            color: "#607D8B"

            SoundPlayer {
                id: soundPlayer
            }
        }
    }

    header: ToolBar {
        id: header

        background: Rectangle {
            color: "#607D8B"
        }

        RowLayout {
            anchors.fill: parent

            ToolButton {
                id: headerForwardComponent

                contentItem: Text {
                    text: parent.text
                    color: "#fff"
                    horizontalAlignment: Text.AlignHCenter
                    verticalAlignment: Text.AlignVCenter
                }

                background: Rectangle {
                    implicitWidth: 40
                    implicitHeight: 40
                    color: "#5f7a87"
                }

                property int indexComponentForward
                text: qsTr("<")

                onClicked: {
                    if (999 != indexComponentForward)
                        stackView.replace(componentsForHeader[indexComponentForward], StackView.PopTransition)
                }

                Shortcut {
                    sequence: "Ctrl+Left"
                    onActivated: 999 != headerForwardComponent.indexComponentForward
                                 ? stackView.replace(
                                       componentsForHeader[headerForwardComponent.indexComponentForward],
                                       StackView.PopTransition
                                       )
                                 : ""
                }
            }

            Label {
                id: headerLabel
                text: qsTr("")
                font.pixelSize: 12 // 13?
                elide: Label.ElideRight
                color: "#fff"
                horizontalAlignment: Qt.AlignHCenter
                verticalAlignment: Qt.AlignVCenter
                Layout.fillWidth: true
            }

            ToolButton {
                id: headerNextComponent

                contentItem: Text {
                    text: parent.text
                    color: "#fff"
                    horizontalAlignment: Text.AlignHCenter
                    verticalAlignment: Text.AlignVCenter
                }

                background: Rectangle {
                    implicitWidth: 40
                    implicitHeight: 40
                    color: "#5f7a87"
                }

                property int indexComponentNext
                text: qsTr(">")

                onClicked: {
                    if (999 != indexComponentNext)
                        stackView.replace(componentsForHeader[indexComponentNext], StackView.PopTransition)
                }

                Shortcut {
                    sequence: "Ctrl+Right"
                    onActivated: 999 != headerNextComponent.indexComponentNext
                                 ? stackView.replace(
                                       componentsForHeader[headerNextComponent.indexComponentNext],
                                       StackView.PopTransition
                                       )
                                 : ""
                }
            }
        }
    }

    StackView {
        id: stackView
        anchors.fill: parent
        initialItem: UserService.authorized() ? animePageComponent : loginPageComponent
        focus: true

        onCurrentItemChanged: {
            currentItem.forceActiveFocus()
        }

        Keys.onPressed: {
            if (event.key === Qt.Key_L)
                musicPlayerItem.visible = musicPlayerItem.visible ? false : true
        }

        Component {
            id: loginPageComponent

            Register {
                Component.onCompleted: {
                    appBackground.source = mainBackground
                    header.visible = false
                }
            }
        }

        Component {
            id: animePageComponent

            Anime {
                Component.onCompleted: {
                    headerLabel.text = textForHeader
                    arrowsForHeader(indexHeader)
                }
            }
        }

        Component {
            id: eachAnimePageComponent

            EachAnime {
            }
        }

        Component {
            id: musicPageComponent

            Music {
                Component.onCompleted: {
                    headerLabel.text = textForHeader
                    arrowsForHeader(indexHeader)
                }
            }
        }
    }
}
