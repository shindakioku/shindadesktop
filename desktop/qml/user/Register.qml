import QtQuick 2.8
import QtQuick.Window 2.2
import QtQuick.Layouts 1.3
import QtQuick.Controls 1.4
import QtQuick.Controls.Styles 1.4

Item {
    id: authQml
    property int cWidth: 500
    property int cHeight: 300

    property string mainBackground: "user/background.jpg"

    Connections {
        target: UserService

        onAuthError: {
            incorrectPassword.visible = true
        }

        onAuthSuccess: {
            stackView.replace(animePageComponent, StackView.PushTransation)
        }
    }

    RowLayout {
        id: incorrectPassword
        visible: false
        anchors.right: parent.right
        anchors.rightMargin: 30
        anchors.top: parent.top
        anchors.topMargin: 285
        spacing: 5

        Rectangle {
            width: 160
            height: 25
            color: "#e74c3c"

            Text {
                color: "white"
                text: "Неправильный пароль"

                font.pixelSize: 10
                anchors.centerIn: parent
            }
        }
    }

    RowLayout {
        anchors.right: parent.right
        anchors.rightMargin: 30
        anchors.top: parent.top
        anchors.topMargin: 200
        spacing: 5

        TextField {
            id: login
            property color borderColor: "white"
            property int borderWidth: 1

            style: TextFieldStyle {
                textColor: "#4e77b7"

                background: Rectangle {
                    radius: 3
                    implicitWidth: 160
                    implicitHeight: 30
                    border.color: login.borderColor
                    border.width: login.borderWidth
                }
            }

            placeholderText: "Логин"

            onTextChanged: {
                if ("#ff0000" == login.borderColor) login.borderColor = "white"
            }
        }
    }

    RowLayout {
        anchors.right: parent.right
        anchors.rightMargin: 30
        anchors.top: parent.top
        anchors.topMargin: 250
        spacing: 5

        TextField {
            id: password
            objectName: "password"
            property color borderColor: "white"
            property int borderWidth: 1

            style: TextFieldStyle {
                textColor: "#4e77b7"

                background: Rectangle {
                    radius: 3
                    implicitWidth: 160
                    implicitHeight: 30
                    border.color: password.borderColor
                    border.width: password.borderWidth
                }
            }

            placeholderText: "****"

            echoMode: TextInput.Password

            onTextChanged: {
                if ("#ff0000" == password.borderColor) password.borderColor = "white"
            }
        }
    }

    RowLayout {
        anchors.right: parent.right
        anchors.rightMargin: 30
        anchors.top: parent.top
        anchors.topMargin: 350
        spacing: 5

        Button {
            id: auth
            objectName: "auth"

            style: ButtonStyle {

                background: Rectangle {
                    color: "#4e77b7"
                    radius: 3
                    implicitWidth: 160
                    implicitHeight: 30
                }
            }

            Text {
                text: "Авторизоваться"
                color: "white"
                font.pointSize: 10
                anchors.centerIn: parent
            }

            onClicked: {
                if(0 == login.text.length) {
                    login.borderColor = "red"
                    login.placeholderText = "Заполните поле"

                    return
                }

                if(0 == password.text.length) {
                    password.borderColor = "red"
                    password.placeholderText = "Заполните поле"

                    return
                }

                UserService.auth(login.text, password.text);
            }
        }
    }
}
