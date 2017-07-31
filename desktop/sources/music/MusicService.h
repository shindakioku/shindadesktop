#pragma once

#include <QObject>
#include <QList>
#include <QJsonArray>
#include <QDir>
#include <QFile>
#include "MusicModel.h"
#include "../request-maker/RequestMaker.h"
#include "../downloader/Downloader.h"

class MusicService : public QObject
{
    Q_OBJECT

public:
    MusicService();

    void musicFromServer(const QString &);

    QJsonArray getMusic();

    Q_INVOKABLE QJsonObject getMusicObject();

    Q_INVOKABLE void download(const QString &, const QString &);

    Q_INVOKABLE void downloadTracks(const QString &, const QString &, const QString &);

private:
    RequestMaker *requestMaker;

    QJsonValue requestReply;

private slots:
    void getResultFromRequest();

signals:
    void musicReady();
};
