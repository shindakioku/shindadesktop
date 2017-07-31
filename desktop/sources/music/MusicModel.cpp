#include "MusicModel.h"

MusicModel::MusicModel(QObject *parent)
    :
      QAbstractListModel(parent),
      musicService(new MusicService)
{
    connect(musicService, &MusicService::musicReady, this, &MusicModel::setMusic);

    connect(this, &MusicModel::urlChanged, [this] () {
        beginResetModel();
        mMusic.clear();
        endResetModel();
    });
}

void MusicModel::addMusic(const MusicList &music)
{
    beginInsertRows(QModelIndex(), rowCount(), rowCount());

    mMusic << music;

    endInsertRows();
}

int MusicModel::rowCount(const QModelIndex &parent) const
{
    Q_UNUSED(parent);

    return mMusic.count();
}

QVariant MusicModel::data(const QModelIndex &index, int role) const
{
    if (index.row() < 0 || index.row() >= mMusic.count())
        return QVariant();

    const MusicList &music = mMusic[index.row()];

    if (role == IdRole)
        return music.id();
    else if(role == NameRole)
        return music.name();
    else if(role == GroupRole)
        return music.groupId();
    else if (role == SourceRole)
        return music.source();

    return QVariant();
}

QVariant MusicModel::get(const int &index, const int &role) const
{
    if (index < 0 || index >= mMusic.count())
        return QVariant();

    const MusicList &music = mMusic[index];

    if (0 == music.id())
        return QVariant();

    if (role == IdRole)
        return music.id();
    else if(role == NameRole)
        return music.name();
    else if(role == GroupRole)
        return music.groupId();
    else if (role == SourceRole)
        return music.source();

    return QVariant();
}

QHash<int, QByteArray> MusicModel::roleNames() const
{
    QHash<int, QByteArray> roles;

    roles[IdRole] = "id";
    roles[NameRole] = "name";
    roles[GroupRole] = "group";
    roles[SourceRole] = "source";

    return roles;
}

void MusicModel::setMusic()
{
    auto result = musicService->getMusic();

    if (0 != result.count())
        emit urlChanged();
    else
    {
        emit noMoreData();

        return;
    }

    foreach (const auto &v, result)
    {
        addMusic(MusicList(
                     v.toObject().value("id").toInt(),
                     v.toObject().value("name").toString(),
                     v.toObject().value("group_id").toInt(),
                     v.toObject().value("source").toString()
                     )
                 );
    }

    emit musicReadyForQml();
}

QString MusicModel::url() const
{
    return "";
}

void MusicModel::setUrl(const QString &url)
{
    musicService->musicFromServer(url);
}
