import React from 'react';
import { StreamApp, NotificationDropdown, FlatFeed, LikeButton, Activity, CommentField, CommentList, StatusUpdateForm } from 'react-activity-feed';

import 'react-activity-feed/dist/index.css';



export default function FeedComponent(props) {
  const title = props.title ?? 'Title prop was left blank'
  const apiKey = '27bjdppvjh4u';
    const appId = '1148439';
    const token = props.token ?? 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMSJ9.0DaRVg_LV1LHZdP18XFaxXH3p6FVc1nuxqRG_N3_72M';
    const location = 'dublin';

  return (
    <>
        <StreamApp apiKey={apiKey} appId={appId} token={token} location={location}>
        <NotificationDropdown notify />
        <StatusUpdateForm />

        <FlatFeed
        feedGroup="user" notify
        options={{ reactions: { recent: true } }}
        Activity={(props) => (
          <Activity
            {...props}
            Footer={() => (
              <div style={{ padding: '8px 16px' }}>
                <LikeButton {...props} />
                <CommentField activity={props.activity} onAddReaction={props.onAddReaction} />
                <CommentList activityId={props.activity.id} />
              </div>
            )}
          />

        )}
        />

        </StreamApp>
    </>
  );
}
