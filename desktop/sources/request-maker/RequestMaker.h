#pragma once

#include <QtNetwork/QNetworkAccessManager>
#include <QtNetwork/QNetworkRequest>
#include <QtNetwork/QNetworkReply>
#include <QUrl>
#include <QTextCodec>
#include <QJsonValue>
#include <QJsonDocument>
#include <QJsonObject>
#include <QObject>
#include <QByteArray>

class RequestMaker : public QObject
{
    Q_OBJECT

public:
    RequestMaker();

    void get(const QString &, const bool & = true);

    void post(const QString &, const QByteArray &, const bool & = true);

    QJsonValue getReply();

private:
    QNetworkAccessManager *manager;

    QString apiUrl;

    QNetworkReply *reply;

    QJsonObject result;

private slots:
    void onFinished();

    void onReadyRead();

    void onReplyFinished();

signals:
    void requestReplyReady();

    //    void requestFileReady();
};
