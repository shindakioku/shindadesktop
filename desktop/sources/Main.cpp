#include <QGuiApplication>
#include <QQmlApplicationEngine>
#include <QQmlContext>
#include <QDir>
#include <QCoreApplication>
#include <QFile>
#include <QSettings>
#include "anime/AnimeService.h"
#include "music/MusicService.h"
#include "user/UserService.h"
#include "anime/AnimeModel.h"
#include "Helper.cpp"
#include "music/MusicModel.h"
#include "updater/Updater.h"

void createMainDirsWithSettings();

int main(int argc, char *argv[])
{
    QGuiApplication app(argc, argv);

    createMainDirsWithSettings();

    QQmlApplicationEngine engine;

    AnimeService anime;
    UserService user;
    MusicService music;
    QSettings settings(
                QStandardPaths::writableLocation(QStandardPaths::DownloadLocation) + "/shinda/settings.ini",
                QSettings::IniFormat
                );
    Updater updater;

    updater.checkVersion();

    qmlRegisterType<AnimeModel>("AnimeModel", 1, 0, "AnimeModel");
    qRegisterMetaType<AnimeModel*>("AnimeModel");

    qmlRegisterType<MusicModel>("MusicModel", 1, 0, "MusicModel");
    qRegisterMetaType<MusicModel*>("MusicModel");

    engine.rootContext()->setContextProperty("AnimeService", &anime);
    engine.rootContext()->setContextProperty("UserService", &user);
    engine.rootContext()->setContextProperty("MusicService", &music);
    engine.rootContext()->setContextProperty("userId", settings.value("user_id").toString());
    engine.rootContext()->setContextProperty("userToken", settings.value("user_token").toString());

    engine.load(QUrl(QStringLiteral("qrc:/qml/Main.qml")));

    if (engine.rootObjects().isEmpty())
        return -1;

    return app.exec();
}

void createMainDirsWithSettings()
{
    auto mainDir = baseDir;

    if (!QDir(mainDir).exists())
        QDir().mkdir(mainDir);

    if (!QDir(mainDir + "anime").exists())
        QDir().mkdir(mainDir + "anime");

    if (!QDir(mainDir + "music").exists())
        QDir().mkdir(mainDir + "music");

    QFile file(mainDir + "settings.ini");

    if (!file.exists())
    {
        file.open(QIODevice::WriteOnly);
        file.close();
    }
}
