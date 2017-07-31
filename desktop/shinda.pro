TEMPLATE = app

QT += qml quick

QT += multimedia

CONFIG += c++11

RC_FILE = shinda.rc

QT += network

SOURCES += sources/Main.cpp \
           sources/Helper.cpp \
           sources/user/UserService.cpp \
           sources/anime/AnimeService.cpp \
           sources/anime/AnimeModel.cpp \
           sources/anime/AnimeList.cpp \
           sources/music/MusicService.cpp \
           sources/music/MusicModel.cpp \
           sources/music/MusicList.cpp \
           sources/request-maker/RequestMaker.cpp \
           sources/downloader/Downloader.cpp \
           sources/updater/Updater.cpp \

HEADERS += sources/user/UserService.h \
           sources/anime/AnimeService.h \
           sources/anime/AnimeModel.h \
           sources/anime/AnimeList.h \
           sources/music/MusicService.h \
           sources/music/MusicList.h \
           sources/music/MusicModel.h \
           sources/request-maker/RequestMaker.h \
           sources/downloader/Downloader.h \
           sources/updater/Updater.h \

RESOURCES += qml.qrc \
             resources/favicon.qrc \
             qml/user/background.jpg \
             qml/players/music/back.svg \
             qml/players/music/next.svg \
             qml/players/music/pause.svg \
             qml/players/music/play.svg \
             qml/players/music/volume.svg \
             qml/players/music/no_volume.svg \
             qml/players/music/repeat.svg \
             qml/players/music/plus.svg \
             qml/players/music/minus.svg \

# Additional import path used to resolve QML modules in Qt Creator's code model
QML_IMPORT_PATH =

# Additional import path used to resolve QML modules just for Qt Quick Designer
QML_DESIGNER_IMPORT_PATH =

# The following define makes your compiler emit warnings if you use
# any feature of Qt which as been marked deprecated (the exact warnings
# depend on your compiler). Please consult the documentation of the
# deprecated API in order to know how to port your code away from it.
DEFINES += QT_DEPRECATED_WARNINGS

# You can also make your code fail to compile if you use deprecated APIs.
# In order to do so, uncomment the following line.
# You can also select to disable deprecated APIs only up to a certain version of Qt.
#DEFINES += QT_DISABLE_DEPRECATED_BEFORE=0x060000    # disables all the APIs deprecated before Qt 6.0.0

# Default rules for deployment.
qnx: target.path = /tmp/$${TARGET}/bin
else: unix:!android: target.path = /opt/$${TARGET}/bin
!isEmpty(target.path): INSTALLS += target
