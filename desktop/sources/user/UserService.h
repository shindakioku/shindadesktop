#pragma once

#include <QObject>
#include <QStandardPaths>
#include <QSettings>
#include <QJsonArray>
#include <QJsonValue>
#include <QByteArray>
#include <QSettings>
#include "../request-maker/RequestMaker.h"

class UserService : public QObject
{
    Q_OBJECT

public:
    UserService();

    Q_INVOKABLE bool authorized() const;

    Q_INVOKABLE void auth(const QString &, const QString &);

    Q_INVOKABLE void hasFavorite(const QString &, const QString &, const QString &);

    Q_INVOKABLE void addFavorite(const QString &, const QString &, const QString &, const QString &);

private:
    RequestMaker *requestMaker;

signals:
    void authSuccess();

    void authError(const QString &);

    Q_INVOKABLE void noFavorite();

    Q_INVOKABLE void isFavorite();

private slots:
    void replyRequest();
};
