#pragma once

#include <QObject>
#include <QList>
#include <QJsonArray>
#include <QDir>
#include <QFile>
#include "AnimeModel.h"
#include "../request-maker/RequestMaker.h"

class AnimeService : public QObject
{
    Q_OBJECT

public:
    AnimeService();

    void animeFromServer(const QString &);

    QJsonArray getAnime();

    Q_INVOKABLE QJsonObject getAnimeObject();

    Q_INVOKABLE void getEachAnime(const QString &);

    Q_INVOKABLE void downloadVideo(const QString &, const QString &, const QString &);

private:
    RequestMaker *requestMaker;

    QJsonValue requestReply;

private slots:
    void getResultFromRequest();

signals:
    void animeReady();
};
