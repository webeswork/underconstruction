            $(document).ready(function(){
                // I added the video size here in case you wanted to modify it more easily
                var vidWidth = 425;
                var vidHeight = 344;

                var obj = '<div style="margin-top:20px"><object width="' + vidWidth + '" height="' + vidHeight + '">' +
                    '<param name="movie" value="http://www.youtube.com/v/[vid]&hl=en&fs=1">' +
                    '</param><param name="allowFullScreen" value="true"></param><param ' +
                    'name="allowscriptaccess" value="always"></param><em' +
                    'bed src="http://www.youtube.com/v/[vid]&hl=en&fs=1" ' +
                    'type="application/x-shockwave-flash" allowscriptaccess="always" ' +
                    'allowfullscreen="true" width="' + vidWidth + '" ' + 'height="' +
                    vidHeight + '"></embed></object></div>';

                $('.post:contains("youtube.com/watch")').each( function(){
                    var that = $(this);
                    var vid = that.html().match(/(?:v=)([\w\-]+)/g); // end up with v=oHg5SJYRHA0
                    if (vid.length) {
                        $.each(vid, function(){
                          that.append( (obj.replace(/\[vid\]/g, this.replace('v=',''))) );

                        });
                    }

                });
            });