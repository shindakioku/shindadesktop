#include "Downloader.h"

Downloader::Downloader()
    :
      manager(new QNetworkAccessManager)
{
}

Downloader::~Downloader()
{
    delete manager;

    delete reply;
}

void Downloader::download(const QUrl &url, const QString &dir, const QString &fileName)
{
    if (!QDir(dir).exists())
        QDir().mkdir(dir);

    if (QFile(fileName).exists())
    {
        emit downloadFinished();

        return;
    }

    QNetworkRequest request;

    file = new QFile;

    file->setFileName(fileName);

    file->open(QIODevice::WriteOnly);

    request.setUrl(QUrl(url));

    reply = manager->get(request);

    connect(manager, SIGNAL(finished(QNetworkReply *)), this, SLOT(onFinished()));

    connect(reply, SIGNAL(readyRead()), this, SLOT(onReadyRead()));

    connect(reply, SIGNAL(finished()), this, SLOT(onReplyFinished()));
}

void Downloader::onFinished()
{
    if (this->file->isOpen())
    {
        file->close();
        delete file;
    }

    emit downloadFinished();
}

void Downloader::onReadyRead()
{
    file->write(reply->readAll());
}

void Downloader::onReplyFinished()
{
    if (file->isOpen())
    {
        file->close();
        delete file;
    }
}
