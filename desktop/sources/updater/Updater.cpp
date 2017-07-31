#include "Updater.h"

Updater::Updater()
    :
      requestMaker(new RequestMaker)
{
    QFile file(QCoreApplication::applicationDirPath() + "/version.ini");

    if (!file.exists())
    {
        file.open(QIODevice::WriteOnly);
        file.close();
    }

    connect(requestMaker, &RequestMaker::requestReplyReady, this, &Updater::newFiles);
}

Updater::~Updater()
{
    delete requestMaker;
}

void Updater::checkVersion()
{
    requestMaker->get("main/version");
}

void Updater::newFiles()
{
    auto result = requestMaker->getReply().toObject().value("response");
    auto path = QCoreApplication::applicationDirPath() + '/';
    auto version = result.toObject().value("version").toDouble();
    QSettings settings(path + "version.ini", QSettings::IniFormat);

    if (settings.value("version").toDouble() != version)
    {
        foreach(const auto &v, result.toObject().value("files").toArray())
        {
            auto downloader = new Downloader;
            auto filePath = v.toObject().value("dir").isUndefined()
                    ? path
                    : path + v.toObject().value("dir").toString();

            downloader->download(QUrl(v.toObject().value("source").toString()), filePath,
                                 filePath + v.toObject().value("name").toString());
        }

        settings.setValue("version", version);
    }
}
