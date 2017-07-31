#pragma once

#include <QAbstractListModel>
#include <QStringList>
#include <QModelIndex>
#include "MusicList.h"
#include "MusicService.h"
#include "../downloader/Downloader.h"

class MusicService;

class MusicModel : public QAbstractListModel
{
    Q_OBJECT

    Q_PROPERTY(QString url READ url WRITE setUrl NOTIFY urlChanged)

public:
    enum MusicRoles {
        IdRole = Qt::UserRole + 1,
        NameRole,
        DurationRole,
        GroupRole,
        SourceRole
    };

    QString url() const;

    void setUrl(const QString &);

    MusicModel(QObject *parent = 0);

    void addMusic(const MusicList &);

    int rowCount(const QModelIndex & = QModelIndex()) const;

    QVariant data(const QModelIndex &, int role = Qt::DisplayRole) const;

    Q_INVOKABLE QVariant get(const int &, const int &) const;

    void setMusic();

protected:
    QHash<int, QByteArray> roleNames() const;

private:
    MusicService *musicService;

    QList<MusicList> mMusic;

signals:
    Q_INVOKABLE void musicReadyForQml();

    void urlChanged();

    Q_INVOKABLE void noMoreData();
};
