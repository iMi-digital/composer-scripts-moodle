= Example =

== Dumping Database to Master Dump ==

    "scripts": {
        "db:dump:master": [
            "@putenv DUMP_STRIP_ADDITIONAL='mdl_users'",
            "IMI\\ComposerScriptsMoodle\\DbDump::dumpToMaster"
        ]
    }