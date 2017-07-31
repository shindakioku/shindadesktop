#pragma once

#include <QAbstractListModel>
#include <QStringList>
#include <QModelIndex>
#include "AnimeList.h"
#include "AnimeService.h"
#include "../downloader/Downloader.h"

class AnimeService;

class AnimeModel : public QAbstractListModel
{
    Q_OBJECT

    Q_PROPERTY(QString url READ url WRITE setUrl NOTIFY urlChanged)

public:
    enum AnimeRoles {
        IdRole = Qt::UserRole + 1,
        NameRole,
        ImageRole
    };

    QString url() const;

    void setUrl(const QString &);

    AnimeModel(QObject *parent = 0);

    void addAnime(const AnimeList &);

    int rowCount(const QModelIndex & = QModelIndex()) const;

    QVariant data(const QModelIndex &, int role = Qt::DisplayRole) const;

    Q_INVOKABLE QVariant get(const int &, const int &) const;

    void setAnime();

protected:
    QHash<int, QByteArray> roleNames() const;

private:
    AnimeService *animeService;

    QList<AnimeList> mAnime;

signals:
    Q_INVOKABLE void animeReadyForQml();

    void urlChanged();

    Q_INVOKABLE void noMoreData();
};
