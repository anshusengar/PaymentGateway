// src/components/ShareButtons.js
import React from "react";
import {
  FacebookShareButton,
  TwitterShareButton,
  WhatsappShareButton,
  FacebookIcon,
  TwitterIcon,
  WhatsappIcon,
} from "react-share";

const ShareButtons = ({ title }) => {
  const shareUrl = window.location.href;

  return (
    <div className="flex gap-3 mt-4">
      <FacebookShareButton url={shareUrl} quote={title}>
        <FacebookIcon size={24} round />
      </FacebookShareButton>

      <TwitterShareButton url={shareUrl} title={title}>
        <TwitterIcon size={24} round />
      </TwitterShareButton>

      <WhatsappShareButton url={shareUrl} title={title}>
        <WhatsappIcon size={24} round />
      </WhatsappShareButton>
    </div>
  );
};

export default ShareButtons;
