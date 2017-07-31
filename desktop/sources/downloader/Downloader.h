#pragma once

#include <QObject>
#include <QNetworkAccessManager>
#include <QNetworkRequest>
#include <QNetworkReply>
#include <QFile>
#include <QStandardPaths>
#include <QDir>
#include <QList>

class Downloader : public QObject
{
    Q_OBJECT

public:
    Downloader();

    virtual ~Downloader();

    void download(const QUrl &, const QString &, const QString &);

private:
    QNetworkAccessManager *manager;

    QNetworkReply *reply;

    QFile *file;

private slots:
    void onFinished();

    void onReadyRead();

    void onReplyFinished();

signals:
    void downloadFinished();
};
