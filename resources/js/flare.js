import { flare } from "@flareapp/flare-client";

// only launch in production, we don't want to waste your quota while you're developing.
if (process.env.NODE_ENV === 'production') {
    flare.light('your-project-key');
}