<?php

namespace getjump\Vk\Constants;


class LongPolling
{
    const
        MESSAGE_DELETED = 0,
        FLAGS_REPLACED = 1,
        FLAGS_SET = 2,
        FLAGS_RESET = 3,
        MESSAGE_ADD = 4,
        MESSAGES_READ_INBOX = 6,
        MESSAGES_READ_OUTBOX = 7,
        FRIEND_ONLINE = 8,
        FRIEND_OFFLINE = 9,
        CHAT_CHANGED = 51,
        MESSAGE_WRITE = 61,
        MESSAGE_WRITE_CHAT = 62,
        INCOMING_CALL = 70,
        NEW_COUNTER = 80,
        DATA_ADD = 101; // DEPRECATED
}
