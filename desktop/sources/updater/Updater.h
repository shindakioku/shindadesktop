#pragma once

#include <QObject>
#include <QJsonValue>
#include <QCoreApplication>
#include <QSettings>
#include <QDir>
#include <QFile>
#include <QJsonArray>
#include <QUrl>
#include "../request-maker/RequestMaker.h"
#include "../downloader/Downloader.h"

class Updater : public QObject
{
    Q_OBJECT

public:
    Updater();

    ~Updater();

    void checkVersion();

private:
    RequestMaker *requestMaker;

private slots:
    void newFiles();
};
