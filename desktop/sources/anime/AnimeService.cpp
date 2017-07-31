#include "AnimeService.h"

AnimeService::AnimeService()
    :
      requestMaker(new RequestMaker)
{
    connect(requestMaker, &RequestMaker::requestReplyReady, this, &AnimeService::getResultFromRequest);
}

void AnimeService::animeFromServer(const QString &url)
{
    requestMaker->get(url);
}

void AnimeService::getResultFromRequest()
{
    requestReply = requestMaker->getReply();

    emit animeReady();
}

QJsonArray AnimeService::getAnime()
{
    return requestReply.toObject().value("response").toArray();
}

QJsonObject AnimeService::getAnimeObject()
{
    return requestReply.toObject().value("response").toObject();
}

void AnimeService::getEachAnime(const QString &id)
{
    requestMaker->get("anime/" + id);
}

void AnimeService::downloadVideo(const QString &dirName, const QString &name, const QString &source)
{
    auto dir = QString("%1/anime/%2/series").arg(baseDir).arg(dirName);
    auto fileName = QString("%1/%2.%3").arg(dir).arg(name).arg("mp4");

    if (!QDir(dir).exists())
        QDir().mkdir(dir);

    auto downloader = new Downloader;

    downloader->download(QUrl(source), dir, fileName);
}
