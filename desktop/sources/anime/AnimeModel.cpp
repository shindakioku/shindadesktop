#include "AnimeModel.h"

AnimeModel::AnimeModel(QObject *parent)
    :
      QAbstractListModel(parent),
      animeService(new AnimeService)
{
    connect(animeService, &AnimeService::animeReady, this, &AnimeModel::setAnime);

    connect(this, &AnimeModel::urlChanged, [this] () {
        beginResetModel();
        mAnime.clear();
        endResetModel();
    });
}

void AnimeModel::addAnime(const AnimeList &anime)
{
    beginInsertRows(QModelIndex(), rowCount(), rowCount());

    mAnime << anime;

    endInsertRows();
}

int AnimeModel::rowCount(const QModelIndex &parent) const
{
    Q_UNUSED(parent);

    return mAnime.count();
}

QVariant AnimeModel::data(const QModelIndex &index, int role) const
{
    if (index.row() < 0 || index.row() >= mAnime.count())
        return QVariant();

    const AnimeList &anime = mAnime[index.row()];

    if (role == IdRole)
        return anime.id();
    else if(role == NameRole)
        return anime.name();
    else if(role == ImageRole)
        return anime.imageName();

    return QVariant();
}

QVariant AnimeModel::get(const int &index, const int &role) const
{
    if (index < 0 || index >= mAnime.count())
        return QVariant();

    const AnimeList &anime = mAnime[index];

    if (0 == anime.id())
        return QVariant();

    if (role == IdRole)
        return anime.id();
    else if(role == NameRole)
        return anime.name();
    else if(role == ImageRole)
        return anime.imageName();

    return QVariant();
}

QHash<int, QByteArray> AnimeModel::roleNames() const
{
    QHash<int, QByteArray> roles;

    roles[IdRole] = "id";
    roles[NameRole] = "name";
    roles[ImageRole] = "image";

    return roles;
}

void AnimeModel::setAnime()
{
    auto result = animeService->getAnime();

    if (0 != result.count())
        emit urlChanged();
    else
    {
        emit noMoreData();

        return;
    }

    foreach (const auto &v, result)
    {
        auto dirWithAnime = baseDir + "anime/" + v.toObject().value("title").toString();
        auto imageName = dirWithAnime + '/' + v.toObject().value("image_name").toString();

        addAnime(AnimeList(
                     v.toObject().value("id").toInt(),
                     v.toObject().value("title").toString(),
                     v.toObject().value("image_url").toString()
                     )
                 );

        auto downloader = new Downloader;

        downloader->download(QUrl(v.toObject().value("image_url").toString()), dirWithAnime, imageName);
    }

    emit animeReadyForQml();
}

QString AnimeModel::url() const
{
    return "";
}

void AnimeModel::setUrl(const QString &url)
{
    animeService->animeFromServer(url);
}
