#include "MusicService.h"

MusicService::MusicService()
    :
      requestMaker(new RequestMaker)
{
    connect(requestMaker, &RequestMaker::requestReplyReady, this, &MusicService::getResultFromRequest);
}

void MusicService::musicFromServer(const QString &url)
{
    requestMaker->get(url);
}

void MusicService::getResultFromRequest()
{
    requestReply = requestMaker->getReply();

    emit musicReady();
}

QJsonArray MusicService::getMusic()
{
    return requestReply.toObject().value("response").toArray();
}

QJsonObject MusicService::getMusicObject()
{
    return requestReply.toObject().value("response").toObject();
}

void MusicService::download(const QString &name, const QString &source)
{
    auto dirWithMusic = QString("%1/music/").arg(baseDir);
    auto fileName = QString("%1/%2.%3").arg(dirWithMusic).arg(name).arg("mp3");

    auto downloader = new Downloader;

    downloader->download(QUrl(source), dirWithMusic, fileName);
}

void MusicService::downloadTracks(const QString &dirName, const QString &name, const QString &source)
{
    auto dir = QString("%1/anime/%2/soundtracks").arg(baseDir).arg(dirName);
    auto fileName = QString("%1/%2.%3").arg(dir).arg(name).arg("mp3");

    if (!QDir(dir).exists())
        QDir().mkdir(dir);

    auto downloader = new Downloader;

    downloader->download(QUrl(source), dir, fileName);
}
