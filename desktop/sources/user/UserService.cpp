#include "UserService.h"

UserService::UserService()
    :
      requestMaker(new RequestMaker)
{
    connect(requestMaker, &RequestMaker::requestReplyReady, this, &UserService::replyRequest);
}

bool UserService::authorized() const
{
    QSettings settings(
                QStandardPaths::writableLocation(QStandardPaths::DownloadLocation) + "/shinda/settings.ini",
                QSettings::IniFormat
                );

    if (0 == settings.value("user_id").toInt())
        return false;

    return true;
}

void UserService::auth(const QString &login, const QString &password)
{
    QByteArray data;

    data.append("login=" + login);
    data.append("&password=" + password);
    data.append("&auth=true");

    requestMaker->post("auth", data);
}

void UserService::hasFavorite(const QString &id, const QString &entityId, const QString &entity)
{
    requestMaker->get(QString("user/%1/has-favorite/%2/%3").arg(id).arg(entity).arg(entityId));
}

void UserService::addFavorite(const QString &id, const QString &token, const QString &entityId, const QString &entity)
{
    QByteArray data;

    data.append("user_id=" + id);
    data.append("&token=" + token);
    data.append("&entity_id=" + entityId);
    data.append("&entity=" + entity);

    requestMaker->post("user/add-favorite", data);
}

void UserService::replyRequest()
{
    auto result = requestMaker->getReply();

    // When using has-favorite
    if (result.toObject().value("response").isBool())
    {
        if (result.toObject().value("response").toBool())
            emit isFavorite();
        else
            emit noFavorite();

        return;
    }

    // When using auth
    if (result.toObject().value("response").toObject().value("token").isString())
    {
        QSettings settings(
                    QStandardPaths::writableLocation(QStandardPaths::DownloadLocation) + "/shinda/settings.ini",
                    QSettings::IniFormat
                    );

        settings.setValue("user_id", result.toObject().value("response").toObject().value("id").toInt());
        settings.setValue("user_token", result.toObject().value("response").toObject().value("token").toString());

        emit authSuccess();
    }
    else
        emit authError("Проверьте правильность пароля");
}
