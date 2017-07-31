#include "RequestMaker.h"

RequestMaker::RequestMaker()
    :
      manager(new QNetworkAccessManager),
      apiUrl("http://shindak.mcdir.ru/public/index.php/api/v1/")
{

}

void RequestMaker::get(const QString &rUrl, const bool &useApi)
{
    QUrl url(true == useApi ? apiUrl + rUrl : rUrl);
    QNetworkRequest request(url);

    reply = manager->get(request);

    connect(manager, &QNetworkAccessManager::finished, this, &RequestMaker::onFinished);

    connect(reply, &QNetworkReply::readyRead, this, &RequestMaker::onReadyRead);

    connect(reply, &QNetworkReply::finished, this, &RequestMaker::onReplyFinished);
}

void RequestMaker::post(const QString &rUrl, const QByteArray &data, const bool &useApi)
{
    QUrl url(true == useApi ? apiUrl + rUrl : rUrl);
    QNetworkRequest request(url);

    request.setHeader(QNetworkRequest::ContentTypeHeader, "application/x-www-form-urlencoded");

    reply = manager->post(request, data);

    connect(manager, &QNetworkAccessManager::finished, this, &RequestMaker::onFinished);

    connect(reply, &QNetworkReply::readyRead, this, &RequestMaker::onReadyRead);

    connect(reply, &QNetworkReply::finished, this, &RequestMaker::onReplyFinished);
}

void RequestMaker::onFinished()
{
    //    manager->deleteLater();
}

void RequestMaker::onReadyRead()
{
    auto jsonDocument = QJsonDocument::fromJson(reply->readAll());
    result = jsonDocument.object();
}

void RequestMaker::onReplyFinished()
{
    //    reply->deleteLater();

    emit requestReplyReady();
}


QJsonValue RequestMaker::getReply()
{
    return result;
}
